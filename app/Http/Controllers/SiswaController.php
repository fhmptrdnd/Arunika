<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectScore;
use App\Models\Subject;
use App\Models\TeacherNote;
use App\Models\Classroom;
use App\Helpers\CognitiveMapper;

class SiswaController extends Controller
{
    // HALAMAN PERKEMBANGAN
    public function perkembangan()
    {
        $siswa = Auth::user();

        // ambil semua skor mapel siswa (gabungan semua source, ambil yang tertinggi per mapel)
        $subjectScores = SubjectScore::where('student_id', $siswa->id)
                                     ->with('subject')
                                     ->get()
                                     ->groupBy('subject_id')
                                     ->map(function ($group) {
                                         // Ambil skor tertinggi jika ada lebih dari 1 source
                                         return $group->sortByDesc('score')->first();
                                     })
                                     ->values();

        // pisah mapel utama (dari placement test) vs lainnya
        $placementScore = SubjectScore::where('student_id', $siswa->id)
                                      ->where('source', 'placement_test')
                                      ->with('subject')
                                      ->orderByDesc('score')
                                      ->first();

        // semua mapel dengan skor (mapel lainnya)
        $semuaSkor = $subjectScores->filter(function ($ss) use ($placementScore) {
            // kalau ada placement test, exclude mapel utamanya dari mapel lainnya
            if ($placementScore && $ss->subject_id === $placementScore->subject_id) {
                return false;
            }
            return true;
        })->sortByDesc('score');

        $kognitif = CognitiveMapper::calculate($subjectScores);

        // catatan dari wali kelas
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
