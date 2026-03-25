<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    // HALAMAN MAPEL PEMINATAN
    public function peminatan()
    {
        $title = "Mapel Peminatan";
        $subtitle = "Fokus pada bakat terhebatmu! Ini adalah mata pelajaran yang paling cocok untukmu.";
        $mapel = "peminatan";
        // Dummy (Nanti diambil dari hasil Placement Test di Database)
        $subjects = [
            ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'matematika'],
        ];

        $user = Auth::user();
        $kelas = $user->kelas;

        return view('mapel.index', compact('title', 'subtitle', 'subjects', 'mapel', 'user', 'kelas'));
    }

    // HALAMAN MAPEL LAINNYA
    public function lainnya()
    {
        $title = "Mapel Lainnya";
        $subtitle = "Dunia ini luas! Yuk jelajahi ilmu-ilmu baru yang tidak kalah seru.";
        $user = Auth::user();
        $kelas = $user->kelas;
        $mapel = "";
        // kelas 1
        if ($kelas == 'Kelas 1') {
            $subjects = [
                ['name' => 'Bahasa Indonesia', 'icon' => '📚', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'bahasa-indonesia'],
                ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'matematika'],
                ['name' => 'Pendidikan Kewarganegaraan', 'icon' => '🏛️', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'pkn']
            ];
        } elseif ($kelas == 'Kelas 2') {
            $subjects = [
                ['name' => 'Bahasa Inggris', 'icon' => '📔', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'bahasa-inggris'],
                ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'matematika'],
                ['name' => 'Bahasa Indonesia', 'icon' => '👋🏻', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'bahasa-indonesia']
            ];
        } elseif ($kelas == 'Kelas 3') {
            $subjects = [
                ['name' => 'Bahasa Inggris', 'icon' => '🔤', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'bahasa-inggris'],
                ['name' => 'Bahasa Indonesia', 'icon' => '👋🏻', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'bahasa-indonesia'],
                ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'matematika'],
            ];
        }

        // Belum dimulai if?
        // ambil semua score user
        $scores = Score::where('user_id', $user->id)->get();

        // mapping progress per mapel + kelas
        $progressMap = [];

        foreach ($scores as $score) {
            $key = $score->mapel . '_' . $score->kelas;

            if (!isset($progressMap[$key])) {
                $progressMap[$key] = [];
            }

            $progressMap[$key][] = $score->level;
        }

        return view('mapel.index', compact('title', 'subtitle', 'subjects', 'user', 'kelas', 'mapel', 'progressMap'));
    }




    // HALAMAN LEVEL
    public function showLevels($slug)
    {

        $subjectName = ucwords(str_replace('-', ' ', $slug));
        $user = Auth::user();
        $kelas = $user->kelas;
        // ambil data score
        $score = Score::where('user_id', $user->id)->first();
        $level = $score ? $score->level : 0;

        return view('mapel.levels', compact('subjectName', 'slug', 'kelas', 'score', 'level'));
    }
}
