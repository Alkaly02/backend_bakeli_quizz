<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question'];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }

    public function choix()
    {
        return $this->hasMany(Choix::class);
    }
}