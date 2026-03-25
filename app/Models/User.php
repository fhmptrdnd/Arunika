<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role',
        'school_code',
        'school_name',
        'kelas',
        'parent_id',
        'xp',
        'streak',
        'last_seen_at',
    ];

    // Jika User ini adalah Guru, dia mengajar di kelas mana saja?
    public function teachingClasses()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teachers', 'teacher_id', 'classroom_id')
                    ->withPivot('subject_id')
                    ->withTimestamps();
    }

    /**
     * Relasi: Orang Tua memiliki banyak Anak (Sub-account)
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Relasi: Anak ini milik Orang Tua siapa?
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // tugas dari guru
    public function assignmentsCreated()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    // submission dari siswa
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    // skor mapel siswa
    public function subjectScores()
    {
        return $this->hasMany(SubjectScore::class, 'student_id');
    }

    // catatan siswa
    public function teacherNotes()
    {
        return $this->hasMany(TeacherNote::class, 'student_id');
    }

    // catatan guru
    public function notesWritten()
    {
        return $this->hasMany(TeacherNote::class, 'teacher_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
