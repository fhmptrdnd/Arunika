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

    public function registerParent()
    {
        return view('auth.register-parent');
    }

    // PROSES REGISTER ADMIN
    public function processRegisterAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'school_name' => 'required',
            'school_code' => 'nullable|unique:users,school_code',
        ], [
            'name.required' => 'Nama wajib diisi ya!',
            'email.required' => 'Email wajib diisi ya!',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal harus 8 karakter.',
            'school_name.required' => 'Nama Sekolah wajib diisi.',
            'school_code.unique' => 'Kode Kelas ini sudah dipakai sekolah lain. Silakan buat yang baru atau kosongkan.',
        ]);

        $kodeKelas = $request->school_code;

        if (empty($kodeKelas)) {
            $kodeKelas = strtoupper(Str::random(6));
            while (User::where('school_code', $kodeKelas)->exists()) {
                $kodeKelas = strtoupper(Str::random(6));
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'school_name' => $request->school_name,
            'school_code' => $kodeKelas,
        ]);

        Auth::login($user);

        return redirect('/admin/dashboard');
    }

    // PROSES REGISTER ORANG TUA (MULTI-ANAK & CUSTOM USERNAME)
    public function processRegisterParent(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'school_code' => 'nullable|exists:users,school_code',

            'children' => 'required|array|min:1',
            'children.*.name' => 'required|string',
            'children.*.username' => 'required|string|unique:users,username',
            'children.*.class_age' => 'required|string',
        ], [
            'name.required' => 'Nama wali wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'school_code.exists' => 'Kode Kelas tidak terdaftar.',
            'children.*.name.required' => 'Nama anak wajib diisi.',
            'children.*.username.required' => 'Username anak wajib diisi.',
            'children.*.username.unique' => 'Oops! Ada username anak yang sudah dipakai orang lain.',
            'children.*.class_age.required' => 'Kelas anak wajib dipilih.',
        ]);

        $namaSekolah = null;
        if (!empty($request->school_code)) {
            $sekolahTerkait = User::where('school_code', $request->school_code)->first();
            $namaSekolah = $sekolahTerkait ? $sekolahTerkait->school_name : null;
        }

        // BUAT AKUN ORANG TUA
        $parent = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent',
            'school_code' => $request->school_code,
            'school_name' => $namaSekolah,
        ]);

        // BUAT AKUN UNTUK MASING-MASING ANAK
        foreach ($request->children as $child) {
            User::create([
                'name' => $child['name'],
                'username' => strtolower(trim($child['username'])),
                'password' => Hash::make($request->password),
                'role' => 'student',
                'parent_id' => $parent->id,
                'kelas' => $child['class_age'],
                'school_code' => $request->school_code,
                'school_name' => $namaSekolah,
                'xp' => 0,
                'streak' => 0,
            ]);
        }

        Auth::login($parent);

        return redirect('/orangtua/profil');
    }

    // LOGIN
    public function processLogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'Email atau Username wajib diisi ya!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'salah_kredensial' => 'Email/Username atau password salah nih. Coba lagi ya!',
        ])->onlyInput('login');
    }

    // SWITCH ACCOUNT
    public function switchAccount(Request $request, $child_id)
    {
        $parent = Auth::user();

        if ($parent->role === 'parent') {
            $child = User::where('id', $child_id)->where('parent_id', $parent->id)->first();

            if ($child) {
                Auth::login($child);
                return redirect('/beranda');
            }
        }

        return back()->with('error', 'Akses ditolak atau anak tidak ditemukan.');
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
