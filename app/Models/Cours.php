<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'sous_domaine_id', "description", 'image'];

    public function sous_domaine()
    {
        return $this->belongsTo(SousDomaine::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }
}
