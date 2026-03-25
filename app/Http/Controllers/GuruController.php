<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\TeacherNote;
use App\Models\SubjectScore;
use App\Helpers\CognitiveMapper;

class GuruController extends Controller
{
    //  DASHBOARD 
    public function dashboard()
    {
        $guru = Auth::user();
        $kelasDiajar = $guru->teachingClasses()->with('homeroomTeacher')->get();
        $namaKelas = $kelasDiajar->pluck('name')->toArray();

        $totalSiswa = User::where('role', 'student')
                          ->where('school_code', $guru->school_code)
                          ->whereIn('kelas', $namaKelas)
                          ->count();

        // tugas hari ini
        $tugasHariIni = Assignment::where('teacher_id', $guru->id)
                                  ->where('due_date', today())
                                  ->where('status', 'active')
                                  ->count();

        // siswa tidak aktif (streak 0)
        $siswaInaktif = User::where('role', 'student')
                            ->where('school_code', $guru->school_code)
                            ->whereIn('kelas', $namaKelas)
                            ->where('streak', 0)
                            ->count();

        return view('guru.dashboard', compact('kelasDiajar', 'totalSiswa', 'tugasHariIni', 'siswaInaktif'));
    }

    //  SISWA KELAS 
    public function siswaKelas(Request $request)
    {
        $guru = Auth::user();
        $kelasDiajar = $guru->teachingClasses()->get();
        $namaKelas = $kelasDiajar->pluck('name')->toArray();

        $query = User::where('role', 'student')
                     ->where('school_code', $guru->school_code)
                     ->whereIn('kelas', $namaKelas);

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $siswa = $query->get();

        return view('guru.siswa-kelas', compact('siswa', 'kelasDiajar'));
    }

    //  KELOLA TUGAS 
    public function kelolaTugas()
    {
        $guru = Auth::user();

        $tugas = Assignment::where('teacher_id', $guru->id)
                           ->with('subject')
                           ->withCount('submissions')
                           ->latest()
                           ->get();

        $kelasDiajar = $guru->teachingClasses()->get();
        $mapelDiajar = Subject::all();

        return view('guru.kelola-tugas', compact('tugas', 'kelasDiajar', 'mapelDiajar'));
    }

    public function buatTugas(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'subject_id'     => 'required|exists:subjects,id',
            'classroom_name' => 'required|string',
            'due_date'       => 'required|date|after_or_equal:today',
        ], [
            'title.required'          => 'Judul tugas wajib diisi!',
            'subject_id.required'     => 'Pilih mata pelajaran dulu ya!',
            'classroom_name.required' => 'Pilih kelas tujuan tugas!',
            'due_date.required'       => 'Tentukan batas waktu pengerjaan!',
            'due_date.after_or_equal' => 'Deadline tidak boleh di masa lalu!',
        ]);

        $guru = Auth::user();

        $tugas = Assignment::create([
            'teacher_id'     => $guru->id,
            'classroom_name' => $request->classroom_name,
            'school_code'    => $guru->school_code,
            'subject_id'     => $request->subject_id,
            'title'          => $request->title,
            'description'    => $request->description,
            'due_date'       => $request->due_date,
            'status'         => 'active',
        ]);

        // submission record "pending"
        $siswaDiKelas = User::where('role', 'student')
                            ->where('school_code', $guru->school_code)
                            ->where('kelas', $request->classroom_name)
                            ->get();

        foreach ($siswaDiKelas as $siswa) {
            AssignmentSubmission::create([
                'assignment_id' => $tugas->id,
                'student_id'    => $siswa->id,
                'status'        => 'pending',
            ]);
        }

        return redirect()->route('guru.tugas')->with('success', 'Tugas "' . $tugas->title . '" berhasil dibuat dan dikirim ke siswa!');
    }

    public function detailTugas($id)
    {
        $guru = Auth::user();
        $tugas = Assignment::where('id', $id)
                           ->where('teacher_id', $guru->id)
                           ->with(['subject', 'submissions.student'])
                           ->firstOrFail();

        return view('guru.detail-tugas', compact('tugas'));
    }

    public function tutupTugas($id)
    {
        $guru = Auth::user();
        $tugas = Assignment::where('id', $id)->where('teacher_id', $guru->id)->firstOrFail();
        $tugas->update(['status' => 'closed']);

        return back()->with('success', 'Tugas telah ditutup.');
    }

    //  PERFORMA SISWA 
    public function performaSiswa()
    {
        $guru = Auth::user();
        $kelasDiajar = $guru->teachingClasses()->get();
        $namaKelas = $kelasDiajar->pluck('name')->toArray();

        $siswa = User::where('role', 'student')
                     ->where('school_code', $guru->school_code)
                     ->whereIn('kelas', $namaKelas)
                     ->get();

        // rata-rata skor per siswa dari semua submission
        $siswa = $siswa->map(function ($s) {
            $avgScore = AssignmentSubmission::where('student_id', $s->id)
                                           ->where('status', 'submitted')
                                           ->avg('score');
            $s->avg_score = round($avgScore ?? 0);
            $s->total_tugas_selesai = AssignmentSubmission::where('student_id', $s->id)
                                                          ->where('status', 'submitted')
                                                          ->count();
            return $s;
        });

        return view('guru.performa-siswa', compact('siswa', 'kelasDiajar'));
    }

    //  PROFIL 
    public function profil()
    {
        return view('guru.profil');
    }

    //  CATATAN GURU 
    public function simpanCatatan(Request $request, $studentId)
    {
        $request->validate([
            'content' => 'required|string|min:10|max:1000',
        ], [
            'content.required' => 'Isi catatan tidak boleh kosong!',
            'content.min'      => 'Catatan terlalu pendek, minimal 10 karakter.',
            'content.max'      => 'Catatan terlalu panjang, maksimal 1000 karakter.',
        ]);

        $guru = Auth::user();
        $siswa = \App\Models\User::findOrFail($studentId);

        $kelas = \App\Models\Classroom::where('name', $siswa->kelas)
                                    ->where('school_code', $guru->school_code)
                                    ->where('homeroom_teacher_id', $guru->id)
                                    ->first();

        if (!$kelas) {
            return back()->withErrors(['Hanya wali kelas yang bisa menulis catatan.']);
        }

        TeacherNote::updateOrCreate(
            ['teacher_id' => $guru->id, 'student_id' => $studentId],
            ['content' => $request->content]
        );

        return back()->with('success', 'Catatan berhasil disimpan!');
    }

    // update include skor kognitif profilSiswa 
    public function profilSiswa($id)
    {
        $guru = Auth::user();
        $siswa = \App\Models\User::where('id', $id)->where('role', 'student')->firstOrFail();

        $submissions = \App\Models\AssignmentSubmission::where('student_id', $id)
                                                        ->with('assignment.subject')
                                                        ->latest()
                                                        ->take(10)
                                                        ->get();

        // skor mapel untuk spider chart
        $subjectScores = SubjectScore::where('student_id', $id)
                                    ->with('subject')
                                    ->get()
                                    ->groupBy('subject_id')
                                    ->map(fn($g) => $g->sortByDesc('score')->first())
                                    ->values();

        $kognitif = CognitiveMapper::calculate($subjectScores);

        $isWaliKelas = false;
        if ($siswa->kelas) {
            $isWaliKelas = \App\Models\Classroom::where('name', $siswa->kelas)
                                                ->where('school_code', $guru->school_code)
                                                ->where('homeroom_teacher_id', $guru->id)
                                                ->exists();
        }

        $catatanGuru = TeacherNote::where('student_id', $id)
                                ->where('teacher_id', $guru->id)
                                ->latest()
                                ->first();

        return view('guru.profil-siswa', compact(
            'siswa', 'submissions', 'kognitif', 'isWaliKelas', 'catatanGuru'
        ));
    }
}
