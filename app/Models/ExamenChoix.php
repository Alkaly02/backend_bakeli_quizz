<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamenChoix extends Model
{
    protected $fillable = ['examen_question_id', 'examen_reponse_id'];
    use HasFactory;

    public function choix(): BelongsTo
    {
        return $this->belongsTo(ExamenQuestion::class);
    }
}