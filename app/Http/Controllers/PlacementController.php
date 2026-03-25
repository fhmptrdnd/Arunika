<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PlacementQuestion;
use App\Models\PlacementResult;

class PlacementController extends Controller
{
    // INTRO
    public function intro()
    {
        $student = Auth::user();

        // sudah pernah tes -> langsung ke hasil
        if (PlacementResult::where('student_id', $student->id)->exists()) {
            return redirect()->route('placement.result');
        }

        $kelas = $student->kelas ?? 'Kelas 3';
        $total = PlacementQuestion::where('kelas', $kelas)->count();

        if ($total === 0) {
            return redirect()->route('beranda')
                ->with('info', 'Tes penempatan belum tersedia untuk kelasmu saat ini.');
        }

        return view('placement.intro', compact('student', 'kelas', 'total'));
    }

    // START TEST
    public function start()
    {
        $student = Auth::user();

        if (PlacementResult::where('student_id', $student->id)->exists()) {
            return redirect()->route('placement.result');
        }

        $kelas     = $student->kelas ?? 'Kelas 3';
        $questions = PlacementQuestion::where('kelas', $kelas)
                        ->orderBy('order')
                        ->get();

        if ($questions->isEmpty()) {
            return redirect()->route('beranda');
        }

        // format questions
        $questionsFormatted = $questions->map(function ($q) {
            return [
                'id'      => $q->id,
                'subject' => $q->subject,
                'text'    => $q->question,
                'options' => [
                    'a' => $q->option_a,
                    'b' => $q->option_b,
                    'c' => $q->option_c,
                    'd' => $q->option_d,
                ],
            ];
        })->toArray();

        return view('placement.test', compact('student', 'kelas', 'questionsFormatted'));
    }

    // SUBMIT
    public function submit(Request $request)
    {
        $student = Auth::user();

        if (PlacementResult::where('student_id', $student->id)->exists()) {
            return redirect()->route('placement.result');
        }

        $kelas     = $student->kelas ?? 'Kelas 3';
        $questions = PlacementQuestion::where('kelas', $kelas)->get()->keyBy('id');
        $answers   = $request->input('answers', []);

        // skor per mapel
        $correct = [];
        $total   = [];

        foreach ($questions as $q) {
            $subj           = $q->subject;
            $total[$subj]   = ($total[$subj] ?? 0) + 1;
            $userAns        = $answers[$q->id] ?? null;
            if ($userAns === $q->correct_answer) {
                $correct[$subj] = ($correct[$subj] ?? 0) + 1;
            }
        }

        $scores = [];
        foreach ($total as $subj => $count) {
            $scores[$subj] = $count > 0
                ? (int) round(($correct[$subj] ?? 0) / $count * 100)
                : 0;
        }

        arsort($scores);
        $subjects = array_keys($scores);

        PlacementResult::create([
            'student_id'     => $student->id,
            'kelas'          => $kelas,
            'scores'         => $scores,
            'answers'        => $answers,
            'top_subject'    => $subjects[0] ?? null,
            'second_subject' => $subjects[1] ?? null,
        ]);

$topSubjectName = $subjects[0] ?? null;

        if ($topSubjectName) {
            $namaMapelBersih = str_replace('_', ' ', $topSubjectName);

            // Pencarian kebal huruf besar/kecil dan spasi
            $subjectModel = \App\Models\Subject::whereRaw('LOWER(name) = ?', [strtolower(trim($namaMapelBersih))])->first();

            if ($subjectModel) {
                // Simpan nilainya ke tabel subject_scores
                \App\Models\SubjectScore::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'subject_id' => $subjectModel->id,
                        'source'     => 'placement_test'
                    ],
                    [
                        // Perhatikan: Kita tetap mengambil skor menggunakan kunci asli yang ada garis bawahnya
                        'score'      => $scores[$topSubjectName],
                        'attempts'   => 1
                    ]
                );
            }
        }

        return redirect()->route('placement.result');
    }

    // HASIL
    public function result()
    {
        $student = Auth::user();
        $result  = PlacementResult::where('student_id', $student->id)->first();

        if (!$result) {
            return redirect()->route('placement.intro');
        }

        $scores = $result->scores;
        arsort($scores);

        return view('placement.result', [
            'student'    => $student,
            'result'     => $result,
            'scores'     => $scores,
            'topSubject' => $result->top_subject,
            'secondSubj' => $result->second_subject,
        ]);
    }
}
