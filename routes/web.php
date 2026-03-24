<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScoreController;
use App\Http\Middleware\IsAdmin;
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
    if (Auth::check()) {
        return redirect()->route('beranda');
    }
    return redirect()->route('login');
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
// Route::get('/mapel/{slug}/level', [MapelController::class, 'showLevels'])->middleware('auth')->name('mapel.levels');
Route::get('/mapel/{slug}/level/{kelas}', [MapelController::class, 'showLevels'])->middleware('auth')->name('mapel.levels');

// Riwayat & Statistik
Route::get('/riwayat', function () {
    return view('placeholder', ['title' => 'Riwayat & Statistik Belajar']);
})->name('riwayat');

Route::get('/placeholder', function () {
    return view('placeholder', ['title' => 'Halaman Placeholder']);
})->name('placeholder');


// MAPEL
Route::get('/indonesia/kelas-1/level-1', function () {
    return view('mapel.1.indo.1', ['mapel' => ['slug' => 'bahasa-indonesia'], 'kelas' => 'Kelas 1']);
})->name('mapel.indo.1.1');
Route::get('/indonesia/kelas-1/level-2', function () {
    return view('mapel.1.indo.2', ['mapel' => ['slug' => 'bahasa-indonesia'], 'kelas' => 'Kelas 2']);
})->name('mapel.indo.1.2');

Route::get('/matematika/kelas-1/level-1', function () {
    return view('mapel.1.matematika.1', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 1']);
})->name('mapel.matematika.1.1');
Route::get('/matematika/kelas-1/level-2', function () {
    return view('mapel.1.matematika.2', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 1']);
})->name('mapel.matematika.1.2');

Route::get('/pkn/kelas-1/level-1', function () {
    return view('mapel.1.pkn.1', ['mapel' => ['slug' => 'pkn'], 'kelas' => 'Kelas 1']);
})->name('mapel.pkn.1.1');
Route::get('/pkn/kelas-1/level-2', function () {
    return view('mapel.1.pkn.2', ['mapel' => ['slug' => 'pkn'], 'kelas' => 'Kelas 1']);
})->name('mapel.pkn.1.2');

// Kelas 2
Route::get('/bahasa-inggris/kelas-2/level-1', function () {
    return view('mapel.2.big.1', ['mapel' => ['slug' => 'bahasa-inggris'], 'kelas' => 'Kelas 2']);
})->name('mapel.big.2.1');
Route::get('/bahasa-inggris/kelas-2/level-2', function () {
    return view('mapel.2.big.2', ['mapel' => ['slug' => 'bahasa-inggris'], 'kelas' => 'Kelas 2']);
})->name('mapel.big.2.2');

Route::get('/matematika/kelas-2/level-1', function () {
    return view('mapel.2.matematika.1', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 2']);
})->name('mapel.mtk.2.1');
Route::get('/matematika/kelas-2/level-2', function () {
    return view('mapel.2.matematika.2', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 2']);
})->name('mapel.mtk.2.2');

Route::get('/indo/kelas-2/level-1', function () {
    return view('mapel.2.indo.1', ['mapel' => ['slug' => 'indo'], 'kelas' => 'Kelas 2']);
})->name('mapel.indo.2.1');
Route::get('/indo/kelas-2/level-2', function () {
    return view('mapel.2.indo.2', ['mapel' => ['slug' => 'indo'], 'kelas' => 'Kelas 2']);
})->name('mapel.indo.2.2');


// Kelas 3
Route::get('/big/kelas-3/level-1', function () {
    return view('mapel.3.big.1', ['mapel' => ['slug' => 'big'], 'kelas' => 'Kelas 3']);
})->name('mapel.big.3.1');
Route::get('/big/kelas-3/level-2', function () {
    return view('mapel.3.big.2', ['mapel' => ['slug' => 'big'], 'kelas' => 'Kelas 3']);
})->name('mapel.big.3.2');

Route::get('/indo/kelas-3/level-1', function () {
    return view('mapel.3.indo.1', ['mapel' => ['slug' => 'indo'], 'kelas' => 'Kelas 3']);
})->name('mapel.indo.3.1');
Route::get('/indo/kelas-3/level-2', function () {
    return view('mapel.3.indo.2', ['mapel' => ['slug' => 'indo'], 'kelas' => 'Kelas 3']);
})->name('mapel.indo.3.2');

Route::get('/matematika/kelas-3/level-1', function () {
    return view('mapel.3.matematika.1', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 3']);
})->name('mapel.mtk.3.1');
Route::get('/matematika/kelas-3/level-2', function () {
    return view('mapel.3.matematika.2', ['mapel' => ['slug' => 'matematika'], 'kelas' => 'Kelas 3']);
})->name('mapel.mtk.3.2');

// Siswa
Route::put('/admin/siswa/{id}', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
Route::delete('/admin/siswa/{id}', [AdminController::class, 'hapusSiswa'])->name('admin.siswa.hapus');

// Guru
Route::put('/admin/guru/{id}', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
Route::delete('/admin/guru/{id}', [AdminController::class, 'hapusGuru'])->name('admin.guru.hapus');

// Score
Route::post('/save-score', [ScoreController::class, 'store']);
