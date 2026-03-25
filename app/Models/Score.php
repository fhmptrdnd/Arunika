<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';
    protected $fillable = ['user_id', 'kelas', 'mapel', 'xp', 'true_answers', 'level', 'literasi', 'logika', 'visual', 'english', 'numerasi', 'created_at', 'updated_at'];
    public $timestamps = true;
}
