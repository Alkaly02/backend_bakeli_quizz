<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentative extends Model
{
    use HasFactory;

    protected $fillable = ['quizz_id', 'score'];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }

    public function choix()
    {
        return $this->hasMany(Choix::class);
    }
}
