<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                        ->orderBy('matchs.date_match')
                        ->get();

        return $matchs;
    }

    public static function getInfoMatch($id) {
        $match = Matchs::join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                        ->where('matchs.Id_Match', $id)
                        ->firstOrFail();

        
        return $match;
    }

    public static function getStatsMatch($id) {
        $stats = Jouer::join('joueurs', 'jouer.licence', '=', 'joueurs.licence')
                    ->where('Id_Match_Basket', '=', $id)
                    ->select('*', DB::raw('jouer.rebond_off + jouer.rebond_def AS rebond'), DB::raw('jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi AS points'))
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
        
        return $stats;
    }

}
