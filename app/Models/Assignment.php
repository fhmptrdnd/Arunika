<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'teacher_id', 'classroom_name', 'school_code',
        'subject_id', 'title', 'description', 'due_date', 'status'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function submissionByStudent($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }

    public function jumlahSelesai()
    {
        return $this->submissions()->where('status', 'submitted')->count();
    }
}
