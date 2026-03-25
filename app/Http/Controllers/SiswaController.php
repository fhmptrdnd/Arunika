<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectScore; // Untuk Mapel Utama (Placement Test)
use App\Models\Score;        // Untuk Mapel Lainnya & Kognitif (Level)
use App\Models\TeacherNote;
use App\Models\Classroom;
// use App\Helpers\CognitiveMapper; // Dinonaktifkan sementara karena kita pakai data Kognitif langsung dari tabel Score

class SiswaController extends Controller
{
    // HALAMAN PERKEMBANGAN
    public function perkembangan()
    {
        $siswa = Auth::user();

        // ==========================================
        // 1. MAPEL UTAMA (Dari Placement Test)
        // ==========================================
        $placementScore = SubjectScore::where('student_id', $siswa->id)
                                      ->where('source', 'placement_test')
                                      ->with('subject')
                                      ->orderByDesc('score')
                                      ->first();

        // dd([
        //     'ID Siswa' => $siswa->id,
        //     'Hasil Placement Score' => $placementScore ? $placementScore->toArray() : 'KOSONG / NULL',
        //     'Cek Relasi Subject' => $placementScore ? $placementScore->subject : 'Tidak bisa cek karena datanya kosong'
        // ]);

        // ==========================================
        // 2. MAPEL LAINNYA (Dari Level yang dimainkan)
        // ==========================================
        // Menghitung berapa banyak level unik (DISTINCT) yang sudah diselesaikan
        $semuaSkor = Score::where('user_id', $siswa->id)
                          ->selectRaw('mapel, COUNT(DISTINCT level) as level_selesai')
                          ->groupBy('mapel')
                          ->get();

        // Filter agar mapel utama tidak muncul dobel di daftar mapel lainnya
        if ($placementScore) {
            $semuaSkor = $semuaSkor->filter(function ($ss) use ($placementScore) {
                return strtolower($ss->mapel) !== strtolower($placementScore->subject->name);
            });
        }

        // ==========================================
        // 3. PERKEMBANGAN KOGNITIF
        // ==========================================
        // Kita hitung rata-rata langsung dari kolom kognitif di tabel Score
        $rataKognitif = Score::where('user_id', $siswa->id)
                             ->selectRaw('
                                 AVG(literasi) as avg_literasi,
                                 AVG(logika) as avg_logika,
                                 AVG(visual) as avg_visual,
                                 AVG(english) as avg_english,
                                 AVG(numerasi) as avg_numerasi
                             ')->first();

        // Susun ke dalam format Array yang siap dibaca oleh Chart.js di View
        $kognitif = [
            'Literasi' => ['score' => round($rataKognitif->avg_literasi ?? 0), 'color' => '#12A0D7', 'icon' => '📖'],
            'Logika'   => ['score' => round($rataKognitif->avg_logika ?? 0), 'color' => '#FBDF54', 'icon' => '🧩'],
            'Visual'   => ['score' => round($rataKognitif->avg_visual ?? 0), 'color' => '#F04F52', 'icon' => '👁️'],
            'Bahasa'   => ['score' => round($rataKognitif->avg_english ?? 0), 'color' => '#6670FF', 'icon' => '💬'],
            'Numerasi' => ['score' => round($rataKognitif->avg_numerasi ?? 0), 'color' => '#05A660', 'icon' => '🔢'],
        ];

        // ==========================================
        // 4. CATATAN DARI GURU
        // ==========================================
        $kelasNama = $siswa->kelas;
        $waliKelas = null;
        $catatanGuru = null;

        if ($kelasNama) {
            $kelas = Classroom::where('name', $kelasNama)
                              ->where('school_code', $siswa->school_code)
                              ->with('homeroomTeacher')
                              ->first();

            if ($kelas && $kelas->homeroomTeacher) {
                $waliKelas = $kelas->homeroomTeacher;

                $catatanGuru = TeacherNote::where('student_id', $siswa->id)
                                          ->where('teacher_id', $waliKelas->id)
                                          ->latest()
                                          ->first();
            }
        }

        return view('siswa.perkembangan', compact(
            'siswa', 'placementScore', 'semuaSkor', 'kognitif', 'waliKelas', 'catatanGuru'
        ));
    }
}
