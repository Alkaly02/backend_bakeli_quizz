<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    public function sous_domaine()
    {
        return $this->belongsTo(SousDomaine::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }
}
