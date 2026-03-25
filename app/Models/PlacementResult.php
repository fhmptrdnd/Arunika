<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementResult extends Model
{
    protected $fillable = [
        'student_id', 'kelas',
        'scores', 'answers',
        'top_subject', 'second_subject'
    ];

    protected $casts = [
        'scores'  => 'array',
        'answers' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
