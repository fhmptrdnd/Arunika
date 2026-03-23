<?php

namespace App\Helpers;

class CognitiveMapper
{
    // mapping dimensi kognitif dari mapel yang berkontribusi
    const MAPPING = [
        'Numerasi' => [
            'subjects' => ['Matematika'],
            'color'    => '#FF6B9D',
            'icon'     => '🔢',
        ],
        'Logika' => [
            'subjects' => ['Matematika', 'Pendidikan Agama'],
            'color'    => '#05A660', 
            'icon'     => '🧩',
        ],
        'Literasi' => [
            'subjects' => ['Bahasa Indonesia', 'Muatan Lokal', 'Pendidikan Agama', 'Bahasa Inggris', 'Pendidikan Pancasila'],
            'color'    => '#27c9ff',
            'icon'     => '📖',
        ],
        'Visual' => [
            'subjects' => ['Seni Budaya', 'Muatan Lokal', 'Pendidikan Jasmani'],
            'color'    => '#F7891F',
            'icon'     => '🎨',
        ],
        'Bahasa Inggris' => [
            'subjects' => ['Bahasa Inggris'],
            'color'    => '#6670FF',
            'icon'     => '🌐',
        ],
    ];

    /**
     * Hitung skor setiap dimensi kognitif dari kumpulan skor mapel siswa.
     * Skor dimensi = rata-rata skor mapel yang berkontribusi.
     *
     * @param \Illuminate\Support\Collection $subjectScores  koleksi SubjectScore dengan relasi subject
     * @return array ['Numerasi' => ['score' => 79, 'color' => '...', 'icon' => '...'], ...]
     */
    public static function calculate($subjectScores): array
    {
        // nama mapel -> skor
        $scoreLookup = $subjectScores->mapWithKeys(function ($ss) {
            return [$ss->subject->name => $ss->score];
        });

        $result = [];

        foreach (self::MAPPING as $dimensi => $config) {
            $relevantScores = [];

            foreach ($config['subjects'] as $subjectName) {
                if (isset($scoreLookup[$subjectName])) {
                    $relevantScores[] = $scoreLookup[$subjectName];
                }
            }

            $result[$dimensi] = [
                'score' => count($relevantScores) > 0
                    ? round(array_sum($relevantScores) / count($relevantScores))
                    : 0,
                'color' => $config['color'],
                'icon'  => $config['icon'],
            ];
        }

        return $result;
    }
}