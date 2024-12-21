<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Jouer;

class Matchs extends Model
{
    use HasFactory;

    protected $table = 'matchs'; // Nom de la table
    protected $primaryKey = 'Id_Match'; // Clé primaire

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

    public static function getInfoMatch($id) {
        $match = Matchs::findOrFail($id);
        $stats = Jouer::join('joueurs', 'jouer.licence', '=', 'joueurs.licence')
                        ->where('Id_Match_Basket', '=', $id)
                        ->get();
        
        return [
            'match' => $match,
            'stats' => $stats
        ];
    }
}
