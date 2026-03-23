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

        // Dummy (Nanti diambil dari hasil Placement Test di Database)
        $subjects = [
            ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'matematika'],
            ['name' => 'Sains Alam', 'icon' => '🔬', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'sains'],
        ];

        return view('mapel.index', compact('title', 'subtitle', 'subjects'));
    }

    // HALAMAN MAPEL LAINNYA
    public function lainnya()
    {
        $title = "Mapel Lainnya";
        $subtitle = "Dunia ini luas! Yuk jelajahi ilmu-ilmu baru yang tidak kalah seru.";
        $user = Auth::user();
        $kelas = $user->kelas;
        // kelas 1
        if ($kelas == 'Kelas 1') {
            $subjects = [
                ['name' => 'Bahasa Indonesia', 'icon' => '📚', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'bahasa-indonesia'],
                ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'matematika'],
                ['name' => 'Pendidikan Kewarganegaraan', 'icon' => '🏛️', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'pkn']
            ];
        } elseif ($kelas == 'Kelas 2') {
            $subjects = [
                ['name' => 'Bahasa Indonesia', 'icon' => '📚', 'color' => 'bg-blue-100', 'text_color' => 'text-blue-600', 'slug' => 'bahasa-indonesia'],
                ['name' => 'Matematika', 'icon' => '🧮', 'color' => 'bg-green-100', 'text_color' => 'text-green-600', 'slug' => 'matematika'],
                ['name' => 'Ilmu Pengetahuan Alam', 'icon' => '🔬', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'ipa']
            ];
        } elseif ($kelas == 'Kelas 3') {
            $subjects = [
                ['name' => 'Bahasa Inggris', 'icon' => '🔤', 'color' => 'bg-yellow-100', 'text_color' => 'text-yellow-600', 'slug' => 'bahasa-inggris'],
                ['name' => 'Seni Budaya', 'icon' => '🎨', 'color' => 'bg-pink-100', 'text_color' => 'text-pink-600', 'slug' => 'seni-budaya'],
                ['name' => 'Sejarah', 'icon' => '🌍', 'color' => 'bg-orange-100', 'text_color' => 'text-orange-600', 'slug' => 'sejarah'],
            ];
        }
        return view('mapel.index', compact('title', 'subtitle', 'subjects', 'user', 'kelas'));
    }


    // HALAMAN LEVEL
    public function showLevels($slug)
    {
        $subjectName = ucwords(str_replace('-', ' ', $slug));
        $user = Auth::user();
        $kelas = $user->kelas;
        // ambil data score
        $score = Score::where('user_id', $user->id)->first();
        return view('mapel.levels', compact('subjectName', 'slug', 'kelas', 'score'));
    }
}
