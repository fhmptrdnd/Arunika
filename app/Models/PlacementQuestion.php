<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementQuestion extends Model
{
    protected $fillable = [
        'kelas', 'subject', 'question',
        'option_a', 'option_b', 'option_c', 'option_d',
        'correct_answer', 'order'
    ];

    public static function subjectLabel(string $subject): string
    {
        return match($subject) {
            'agama'            => 'Pend. Agama & Budi Pekerti',
            'pancasila'        => 'Pendidikan Pancasila',
            'bahasa_indonesia' => 'Bahasa Indonesia',
            'matematika'       => 'Matematika',
            'pjok'             => 'PJOK',
            'seni_budaya'      => 'Seni dan Budaya',
            'bahasa_inggris'   => 'Bahasa Inggris',
            'muatan_lokal'     => 'Muatan Lokal',
            default            => ucwords(str_replace('_', ' ', $subject)),
        };
    }

    public static function subjectIcon(string $subject): string
    {
        return match($subject) {
            'agama'            => '🛐',
            'pancasila'        => '⚖️',
            'bahasa_indonesia' => '📖',
            'matematika'       => '🔢',
            'pjok'             => '🏃‍♂️',
            'seni_budaya'      => '🎨',
            'bahasa_inggris'   => '🗣️',
            'muatan_lokal'     => '🌎',
            default            => '📚',
        };
    }
}
