<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    use HasFactory;

    protected $table = 'saisons'; // Nom de la table
    protected $primaryKey = 'Id_Saison'; // Clé primaire

    protected $fillable = [
        'année_debut',
        'année_fin',
        'championnat',
        'catégorie',
    ];
}
