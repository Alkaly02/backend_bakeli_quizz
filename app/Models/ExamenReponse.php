<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamenReponse extends Model
{
    protected $fillable = ['reponse', 'is_correct', 'examen_question_id'];
    use HasFactory;

    public function question(): BelongsTo
    {
        return $this->belongsTo(ExamenQuestion::class);
    }
}
