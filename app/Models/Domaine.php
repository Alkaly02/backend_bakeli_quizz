<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'theme', "description", "text_color"];

    public function sous_domaines()
    {
        return $this->hasMany(SousDomaine::class);
    }
}
