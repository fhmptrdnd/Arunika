<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function studentList(Request $request)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return redirect('/beranda')->with('error_popup', 'Hanya admin sekolah yang bisa melihat daftar murid.');
        }

        $query = \App\Models\User::where('role', 'parent')
                                 ->where('school_code', $admin->school_code);

        // Fitur search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('child_name', 'LIKE', '%' . $searchTerm . '%');
        }

        $students = $query->get();

        return view('profile.students', compact('students'));
    }

    public function showStudent($id)
    {
        $admin = Auth::user();
        if ($admin->role !== 'admin') return redirect('/beranda');

        $student = \App\Models\User::where('id', $id)
            ->where('role', 'parent')
            ->where('school_code', $admin->school_code)
            ->firstOrFail();

        return view('profile.student-detail', compact('student'));
    }

    // MENGELUARKAN MURID
    public function kickStudent($id)
    {
        $admin = Auth::user();
        if ($admin->role !== 'admin') return redirect('/beranda');

        $student = \App\Models\User::where('id', $id)
            ->where('school_code', $admin->school_code)
            ->firstOrFail();

        $student->update([
            'school_code' => null,
            'school_name' => null
        ]);

        return redirect()->route('profile.students')->with('error_popup', 'Murid berhasil dikeluarkan dari kelas.');
    }

    // KODE SEKOLAH BARU
    public function updateSchoolCode(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'parent') return redirect('/beranda');

        $request->validate([
            'school_code' => 'required|exists:users,school_code'
        ], [
            'school_code.required' => 'Kode sekolah tidak boleh kosong.',
            'school_code.exists' => 'Ups! Kode sekolah tidak ditemukan.',
        ]);

        $adminSekolah = \App\Models\User::where('school_code', $request->school_code)->first();

        $user->update([
            'school_code' => $request->school_code,
            'school_name' => $adminSekolah->school_name
        ]);

        return back();
    }
}
