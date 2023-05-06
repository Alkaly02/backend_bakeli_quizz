<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examen extends Model
{
    protected $fillable = ['name', 'sous_domaine_id', 'session', 'status', 'duree'];
    use HasFactory;

    public function questions(): HasMany
    {
        return $this->hasMany(ExamenQuestion::class);
    }

    public function sous_domaine(): BelongsTo
    {
        return $this->belongsTo(SousDomaine::class);
    }
}
