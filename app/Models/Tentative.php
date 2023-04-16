<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentative extends Model
{
    use HasFactory;

    protected $fillable = ['quizz_id', 'reponses', 'score'];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}
