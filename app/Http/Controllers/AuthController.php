<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function registerRole() {
        return view('auth.register-role');
    }

    // MENAMPILKAN HALAMAN DAFTAR ADMIN
    public function registerAdmin()
    {
        return view('auth.register-admin');
    }

    // REGISTER ADMIN / GURU
    public function processRegisterAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'school_name' => 'required',
            'class_code' => 'nullable|exists:users,class_code',
        ], [
            'name.required' => 'Nama wajib diisi ya!',
            'email.required' => 'Email wajib diisi ya!',
            'email.email' => 'Ups! Format emailnya sepertinya kurang tepat.',
            'password.required' => 'Password tidak boleh kosong!',
            'school_name.required' => 'Nama Sekolah wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'class_code.exists' => 'Ups! Kode Kelas tidak ditemukan. Kosongkan saja jika ingin mendaftarkan kelas baru.',
        ]);

        $kodeKelas = $request->class_code;

        if (empty($kodeKelas)) {
            $kodeKelas = strtoupper(Str::random(6));

            while (User::where('class_code', $kodeKelas)->exists()) {
                $kodeKelas = strtoupper(Str::random(6));
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'school_name' => $request->school_name,
            'class_code' => $kodeKelas,
        ]);

        Auth::login($user);

        return redirect('/beranda');
    }

    public function registerParent() {
        return view('auth.register-parent');
    }


    // REGISTER ORANG TUA
    public function processRegisterParent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'child_name' => 'required',
            'class_age' => 'required',
            'class_code' => 'required|exists:users,class_code',
        ], [
            'name.required' => 'Nama wali/orang tua wajib diisi ya!',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain atau login.',
            'email.required' => 'Email wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter ya!',
            'password.required' => 'Password wajib diisi.',
            'child_name.required' => 'Nama Anak wajib diisi.',
            'class_age.required' => 'Kelas/Usia wajib diisi.',
            'class_code.required' => 'Kode Kelas wajib diisi.',
            'class_code.exists' => 'Ups! Kode Kelas tidak terdaftar. Pastikan kodenya benar.',
        ]);

        $kelasTerkait = User::where('class_code', $request->class_code)->first();
        $namaKelas = $kelasTerkait ? $kelasTerkait->school_name : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent',
            'child_name' => $request->child_name,
            'class_age' => $request->class_age,
            'class_code' => $request->class_code,
            'school_name' => $namaKelas,
        ]);

        Auth::login($user);

        return redirect('/beranda');
    }

    // LOGIN
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi ya!',
            'email.email' => 'Ups! Format emailnya sepertinya kurang tepat.',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/beranda');
        }

        return back()->withErrors([
            'salah_kredensial' => 'Email atau password salah nih. Coba lagi ya!',
        ])->onlyInput('email');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/masuk');
    }
}
