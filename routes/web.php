<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapelController;
use GuzzleHttp\Middleware;

// Auth
Route::get('/masuk', [AuthController::class, 'login'])->name('login');
Route::post('/masuk', [AuthController::class, 'processLogin']);

Route::get('/daftar', [AuthController::class, 'registerRole'])->name('register');
Route::get('/daftar/orang-tua', [AuthController::class, 'registerParent'])->name('register.parent');
Route::post('/daftar/orang-tua', [AuthController::class, 'processRegisterParent']);

Route::get('/daftar/admin', [AuthController::class, 'registerAdmin'])->name('register.admin');
Route::post('/daftar/admin', [AuthController::class, 'processRegisterAdmin']);

Route::get('/profil', [ProfileController::class, 'index'])->middleware('auth')->name('profile');
Route::get('/profil/murid', [ProfileController::class, 'studentList'])->middleware('auth')->name('profile.students');

Route::get('/profil/murid/{id}', [ProfileController::class, 'showStudent'])->middleware('auth')->name('profile.student.detail');
Route::post('/profil/murid/{id}/keluarkan', [ProfileController::class, 'kickStudent'])->middleware('auth')->name('profile.student.kick');
Route::post('/profil/update-kode-sekolah', [ProfileController::class, 'updateSchoolCode'])->middleware('auth')->name('profile.update.school');

Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

// Middleware
Route::get('/beranda', function () {
    if (Auth::check()){
        return redirect()->route('beranda');
    }
    return redirect()->route('login');
});

// Beranda
Route::get('/', function () {
    return view('beranda');
})->middleware('auth')->name('beranda');

// Mapel Peminatan
// Route::get('/mapel-peminatan', function () {
//     return view('placeholder', ['title' => 'Mata Pelajaran Peminatan']);
// })->name('mapel.peminatan');
Route::get('/mapel/peminatan', [MapelController::class, 'peminatan'])->middleware('auth')->name('mapel.peminatan');

// Mapel Lainnya
// Route::get('/mapel-lainnya', function () {
//     return view('placeholder', ['title' => 'Mata Pelajaran Lainnya']);
//     })->name('mapel.lainnya');
Route::get('/mapel/lainnya', [MapelController::class, 'lainnya'])->middleware('auth')->name('mapel.lainnya');

// Level
Route::get('/mapel/{slug}/level', [MapelController::class, 'showLevels'])->middleware('auth')->name('mapel.levels');

// Riwayat & Statistik
Route::get('/riwayat', function () {
    return view('placeholder', ['title' => 'Riwayat & Statistik Belajar']);
})->name('riwayat');

Route::get('/placeholder', function () {
    return view('placeholder', ['title' => 'Halaman Placeholder']);
})->name('placeholder');
