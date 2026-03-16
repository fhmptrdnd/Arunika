<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. HALAMAN BERANDA (DASHBOARD)
    public function dashboard()
    {
        $admin = Auth::user();
        $kodeSekolah = $admin->school_code;

        $totalSiswa = User::where('role', 'student')->where('school_code', $kodeSekolah)->count();
        $totalGuru = User::where('role', 'guru')->where('school_code', $kodeSekolah)->count();
        $totalKelas = Classroom::where('school_code', $kodeSekolah)->count();
        $onlineUsers = User::where('school_code', $kodeSekolah)
                           ->whereNotNull('last_seen_at')
                           ->where('last_seen_at', '>=', now()->subMinutes(5))
                           ->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalKelas', 'onlineUsers'));
    }

    // HALAMAN DATA SISWA
    public function siswa(Request $request)
    {
        $admin = Auth::user();
        $search = $request->input('search');

        $query = User::where('role', 'student')
                     ->where('school_code', $admin->school_code);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        $siswa = $query->get();

        return view('admin.data-siswa', compact('siswa'));
    }

    // HALAMAN DATA GURU
    public function guru(Request $request)
    {
        $admin = Auth::user();
        $search = $request->input('search');

        $query = User::where('role', 'guru')
                     ->where('school_code', $admin->school_code);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $guru = $query->get();

        return view('admin.data-guru', compact('guru'));
    }

    // 4. HALAMAN MANAJEMEN KELAS
    public function kelas()
    {
        $admin = Auth::user();

        $kelas = Classroom::with('homeroomTeacher')
                          ->where('school_code', $admin->school_code)
                          ->get();

        $semuaGuru = User::where('role', 'guru')->where('school_code', $admin->school_code)->get();

        return view('admin.manajemen-kelas', compact('kelas', 'semuaGuru'));
    }

    // MENYIMPAN DATA KELAS BARU
    public function storeKelas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama kelas wajib diisi ya!',
        ]);

        $admin = Auth::user();

        Classroom::create([
            'name' => $request->name,
            'school_code' => $admin->school_code,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);

        return redirect()->back()->with('success', 'Kelas '.$request->name.' berhasil dibuat!');
    }

    // HALAMAN KELOLA KELAS SPESIFIK
    public function kelolaKelas($id)
    {
        $admin = Auth::user();
        $kelas = Classroom::with(['homeroomTeacher', 'subjectTeachers'])->findOrFail($id);

        if ($kelas->school_code !== $admin->school_code) { abort(403); }

        $siswaDiKelas = User::where('role', 'student')->where('school_code', $admin->school_code)->where('kelas', $kelas->name)->get();

        $siswaTersedia = User::where('role', 'student')
                             ->where('school_code', $admin->school_code)
                             ->where(function($query) use ($kelas) {
                                 $query->where('kelas', '!=', $kelas->name)->orWhereNull('kelas');
                             })->get();

        $semuaGuru = User::where('role', 'guru')->where('school_code', $admin->school_code)->get();
        $semuaMapel = \App\Models\Subject::all();

        return view('admin.kelola-kelas', compact('kelas', 'siswaDiKelas', 'siswaTersedia', 'semuaGuru', 'semuaMapel'));
    }

    public function tambahSiswaKelas(Request $request, $id)
    {
        $kelas = Classroom::findOrFail($id);
        $siswa = User::findOrFail($request->student_id);

        $siswa->update(['kelas' => $kelas->name]);
        return back()->with('success', $siswa->name . ' berhasil dimasukkan ke kelas!');
    }

    public function hapusSiswaKelas(Request $request, $id)
    {
        $siswa = User::findOrFail($request->student_id);
        $siswa->update(['kelas' => null]);
        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    public function tambahGuruMapel(Request $request, $id)
    {
        $kelas = Classroom::findOrFail($id);

        // Cek guru ini sudah ngajar mapel yang sama di kelas ini apa belom
        $sudahAda = \Illuminate\Support\Facades\DB::table('classroom_teachers')
            ->where('classroom_id', $kelas->id)->where('teacher_id', $request->teacher_id)->where('subject_id', $request->subject_id)->exists();

        if($sudahAda) {
            return back()->withErrors(['Guru tersebut sudah mengajar mata pelajaran ini di kelas ini!']);
        }

        $kelas->subjectTeachers()->attach($request->teacher_id, ['subject_id' => $request->subject_id]);
        return back()->with('success', 'Guru Mata Pelajaran berhasil ditambahkan!');
    }

    public function hapusGuruMapel(Request $request, $id)
    {
        \Illuminate\Support\Facades\DB::table('classroom_teachers')
            ->where('classroom_id', $id)->where('teacher_id', $request->teacher_id)->where('subject_id', $request->subject_id)->delete();

        return back()->with('success', 'Guru Mata Pelajaran berhasil dihapus.');
    }

    // FUNGSI TAMBAH SISWA MANUAL
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ], [
            'username.unique' => 'Username ini sudah dipakai, coba yang lain ya!',
        ]);

        $admin = Auth::user();

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'school_code' => $admin->school_code,
            'school_name' => $admin->school_name,
            'xp' => 0,
            'streak' => 0,
        ]);

        return redirect()->back()->with('success', 'Siswa '.$request->name.' berhasil didaftarkan!');
    }

    // FUNGSI TAMBAH GURU MANUAL
    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'Email ini sudah terdaftar sebelumnya!',
        ]);

        $admin = Auth::user();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'school_code' => $admin->school_code,
            'school_name' => $admin->school_name,
        ]);

        return redirect()->back()->with('success', 'Guru '.$request->name.' berhasil didaftarkan!');
    }

    public function profil()
    {
        return view('admin.profil');
    }
}
