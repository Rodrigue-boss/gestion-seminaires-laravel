<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'resume',
        'date',
        'heure_debut',
        'heure_fin',
        'salle',
        'lien_visio',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}

