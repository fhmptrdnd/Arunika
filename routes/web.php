<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuru;
use GuzzleHttp\Middleware;
use App\Http\Controllers\PlacementController;

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

// Beranda route (single entrypoint for authenticated users)
Route::get('/', function () {
    return view('beranda');
})->middleware(['auth', 'placement.done'])->name('beranda');

Route::middleware('auth')->group(function () {
    Route::get('/perkembangan', [SiswaController::class, 'perkembangan'])->name('siswa.perkembangan');
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/data-siswa', [AdminController::class, 'siswa'])->name('siswa');
    Route::post('/data-siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');

    Route::get('/data-guru', [AdminController::class, 'guru'])->name('guru');
    Route::post('/data-guru', [AdminController::class, 'storeGuru'])->name('guru.store');

    Route::get('/manajemen-kelas', [AdminController::class, 'kelas'])->name('kelas');
    Route::post('/manajemen-kelas', [AdminController::class, 'storeKelas'])->name('kelas.store');
    Route::get('/manajemen-kelas/{id}', [AdminController::class, 'kelolaKelas'])->name('kelas.kelola');

    Route::post('/manajemen-kelas/{id}/tambah-siswa', [AdminController::class, 'tambahSiswaKelas'])->name('kelas.tambah-siswa');
    Route::post('/manajemen-kelas/{id}/hapus-siswa', [AdminController::class, 'hapusSiswaKelas'])->name('kelas.hapus-siswa');
    Route::post('/manajemen-kelas/{id}/tambah-guru', [AdminController::class, 'tambahGuruMapel'])->name('kelas.tambah-guru-mapel');
    Route::post('/manajemen-kelas/{id}/hapus-guru', [AdminController::class, 'hapusGuruMapel'])->name('kelas.hapus-guru-mapel');

    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');

});

Route::middleware(['auth', IsGuru::class])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa-kelas', [GuruController::class, 'siswaKelas'])->name('siswa');
    Route::get('/siswa-kelas/{id}', [GuruController::class, 'profilSiswa'])->name('siswa.profil');
    Route::post('/siswa-kelas/{id}/catatan', [GuruController::class, 'simpanCatatan'])->name('siswa.catatan');
    
    // TUGAS
    Route::get('/kelola-tugas', [GuruController::class, 'kelolaTugas'])->name('tugas');
    Route::post('/kelola-tugas', [GuruController::class, 'buatTugas'])->name('tugas.buat');
    Route::get('/kelola-tugas/{id}', [GuruController::class, 'detailTugas'])->name('tugas.detail');
    Route::post('/kelola-tugas/{id}/tutup', [GuruController::class, 'tutupTugas'])->name('tugas.tutup');

    Route::get('/profil', [GuruController::class, 'profil'])->name('profil');
// PLACEMENT TEST STUDENT (non-admin routes)
Route::middleware('auth')->group(function () {
    Route::get('/placement-test',         [PlacementController::class, 'intro'])  ->name('placement.intro');
    Route::get('/placement-test/mulai',   [PlacementController::class, 'start'])  ->name('placement.start');
    Route::post('/placement-test/submit', [PlacementController::class, 'submit']) ->name('placement.submit');
    Route::get('/placement-test/hasil',   [PlacementController::class, 'result']) ->name('placement.result');
});

// // Admin Dashboard
// Route::get('/admin/dashboard', function (Request $request) {
//     if ($request->user()->role !== 'admin') {
//         return redirect('/beranda');
//     }

//     return view('admin.dashboard');
// })->middleware('auth')->name('admin.dashboard');
// // Admin Controller
// Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');
// // Data Siswa & Guru
// Route::get('/admin/data-siswa', function (Illuminate\Http\Request $request) {
//     if ($request->user()->role !== 'admin') return redirect('/beranda');
//     return view('admin.data-siswa');
// })->middleware('auth')->name('admin.siswa');

// Route::get('/admin/data-guru', function (Illuminate\Http\Request $request) {
//     if ($request->user()->role !== 'admin') return redirect('/beranda');
//     return view('admin.data-guru');
// })->middleware('auth')->name('admin.guru');
// // Manajemen Kelas & Profil Admin
// Route::get('/admin/manajemen-kelas', function (Illuminate\Http\Request $request) {
//     if ($request->user()->role !== 'admin') return redirect('/beranda');
//     return view('admin.manajemen-kelas');
// })->middleware('auth')->name('admin.kelas');

// Route::get('/admin/profil', function (Illuminate\Http\Request $request) {
//     if ($request->user()->role !== 'admin') return redirect('/beranda');
//     return view('admin.profil');
// })->middleware('auth')->name('admin.profil');

// Profil Ortu
Route::get('/orangtua/profil', function (Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'parent') return redirect('/beranda');
    return view('parent.profile');
})->middleware('auth')->name('parent.profil');
// Switch Account
Route::get('/switch-account/{id}', [App\Http\Controllers\AuthController::class, 'switchAccount'])->middleware('auth')->name('switch.account');

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
