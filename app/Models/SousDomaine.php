<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousDomaine extends Model
{
    use HasFactory;

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
