<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamenQuestion extends Model
{
    protected $fillable = ['question', 'examen_id'];
    use HasFactory;

    public function examen(): BelongsTo
    {
        return $this->belongsTo(Examen::class);
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(ExamenReponse::class);
    }
}
