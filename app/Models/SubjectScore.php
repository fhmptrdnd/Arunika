<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectScore extends Model
{
    protected $fillable = ['student_id', 'subject_id', 'score', 'source', 'attempts'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
