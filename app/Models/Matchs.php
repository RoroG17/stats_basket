<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchs extends Model
{
    use HasFactory;

    protected $table = 'matchs'; // Nom de la table
    protected $primaryKey = 'Id_Match_Basket'; // Clé primaire

    protected $fillable = [
        'numero',
        'domicile',
        'victoire',
        'Id_Equipe',
        'Id_Saison',
    ];
}
