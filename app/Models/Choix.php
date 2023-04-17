<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choix extends Model
{
    use HasFactory;

    protected $fillable = ['reponse_id'];

    protected $hidden = ['question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}