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

    public static function getAllMatchs() {
        $matchs = Matchs::join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                        ->get();

        return $matchs;
    }
}
