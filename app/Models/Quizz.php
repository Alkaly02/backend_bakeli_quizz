<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quizz extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cours_id'];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function tentatives()
    {
        return $this->hasMany(Tentative::class);
    }
}
