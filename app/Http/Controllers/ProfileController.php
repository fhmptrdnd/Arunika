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
                                 ->where('class_code', $admin->class_code);

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
            ->where('class_code', $admin->class_code)
            ->firstOrFail();

        return view('profile.student-detail', compact('student'));
    }

    // MENGELUARKAN MURID
    public function kickStudent($id)
    {
        $admin = Auth::user();
        if ($admin->role !== 'admin') return redirect('/beranda');

        $student = \App\Models\User::where('id', $id)
            ->where('class_code', $admin->class_code)
            ->firstOrFail();

        $student->update([
            'class_code' => null,
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
            'class_code' => 'required|exists:users,class_code'
        ], [
            'class_code.required' => 'Kode sekolah tidak boleh kosong.',
            'class_code.exists' => 'Ups! Kode sekolah tidak ditemukan.',
        ]);

        $adminSekolah = \App\Models\User::where('class_code', $request->class_code)->first();

        $user->update([
            'class_code' => $request->class_code,
            'school_name' => $adminSekolah->school_name
        ]);

        return back();
    }
}
