<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'school_code', 'homeroom_teacher_id'];

    // Relasi ke WALI KELAS (1 orang)
    public function homeroomTeacher()
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    // Relasi ke GURU-GURU MAPEL (Banyak orang lewat tabel penghubung)
    public function subjectTeachers()
    {
        // Mengambil user (guru) melalui tabel classroom_teachers
        return $this->belongsToMany(User::class, 'classroom_teachers', 'classroom_id', 'teacher_id')
                    ->withPivot('subject_id')
                    ->withTimestamps();
    }
}
