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
        $user = Auth::user();
        $kelas = $user->kelas ?? 'Kelas 3';

        $title = "Mapel Peminatan";
        $subtitle = "Fokus pada bakat terhebatmu! Ini adalah mata pelajaran yang paling cocok untukmu.";
        $mapel = "peminatan";

        $placement = \App\Models\PlacementResult::where('student_id', $user->id)->first();
        $topSubjectRaw = $placement ? $placement->top_subject : null;

        $topSubjectSlug = $topSubjectRaw ? strtolower(str_replace(['_', ' '], '-', trim($topSubjectRaw))) : null;

        $subjectDictionary = [
            'matematika' => [
                'name' => 'Matematika',
                'icon' => '🧮',
                'color' => 'bg-[#FEF5D3]',
                'text_color' => 'text-[#d4ac1e]',
                'slug' => 'matematika'
            ],
            'bahasa-indonesia' => [
                'name' => 'Bahasa Indonesia',
                'icon' => '📖',
                'color' => 'bg-[#EAF7FC]',
                'text_color' => 'text-[#12A0D7]',
                'slug' => 'bahasa-indonesia'
            ],
            'bahasa-inggris' => [
                'name' => 'Bahasa Inggris',
                'icon' => '🗽',
                'color' => 'bg-[#EEEEFF]',
                'text_color' => 'text-[#6670FF]',
                'slug' => 'bahasa-inggris'
            ],
        ];

        if (!array_key_exists($topSubjectSlug, $subjectDictionary)) {
            $topSubjectSlug = 'bahasa-indonesia';
        }

        $subjects = [ $subjectDictionary[$topSubjectSlug] ];

        $scoresDb = \App\Models\Score::where('user_id', $user->id)
            ->selectRaw('mapel, COUNT(DISTINCT level) as level_selesai')
            ->groupBy('mapel')
            ->get();

        $progresSiswa = [];
        foreach ($scoresDb as $score) {
            $key = strtolower(str_replace(' ', '_', trim($score->mapel)));
            $progresSiswa[$key] = $score->level_selesai;
        }

        return view('mapel.index', compact(
            'title', 'subtitle', 'subjects', 'mapel', 'user', 'kelas', 'progresSiswa'
        ));
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

                $scoresDb = \App\Models\Score::where('user_id', $user->id)
            ->selectRaw('mapel, COUNT(DISTINCT level) as level_selesai')
            ->groupBy('mapel')
            ->get();

        $progresSiswa = [];
        foreach ($scoresDb as $score) {
            $key = strtolower(str_replace(' ', '-', trim($score->mapel)));
            $progresSiswa[$key] = $score->level_selesai;
        }

        // dd([
        //     'ID Siswa yang login' => $user->id,
        //     'Isi Data Mentah dari DB' => $scoresDb->toArray(),
        //     'Keranjang Progres Akhir' => $progresSiswa
        // ]);

        return view('mapel.index', compact(
            'title', 'subtitle', 'subjects', 'mapel', 'user', 'kelas', 'progresSiswa'
        ));
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
