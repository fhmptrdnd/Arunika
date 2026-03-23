<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherNote extends Model
{
    protected $fillable = ['teacher_id', 'student_id', 'content'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
