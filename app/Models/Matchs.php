<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                        ->select('Id_Match', 'matchs.date_match', 'matchs.numero', 'matchs.domicile', 'matchs.score_f', 'matchs.score_a', 'equipes.nom', 'equipes.logo')
                        ->get();

        return $matchs;
    }

    public static function getInfoMatch($id) {
        $match = Matchs::join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                        ->where('matchs.Id_Match', $id)
                        ->select('Id_Match', 'matchs.date_match', 'matchs.numero', 'matchs.domicile', 'matchs.score_f', 'matchs.score_a', 'equipes.nom', 'equipes.logo')
                        ->firstOrFail();

        
        return $match;
    }

    public static function getStatsEquipeMatch($id) {
        $stats = Matchs::where('matchs.Id_Match', $id)
                        ->select(
                            'PD1', 'PD2', 'PD3', 'PD4',
                            'ROff1', 'ROff2', 'ROff3', 'ROff4',
                            'RDef1', 'RDef2', 'RDef3', 'RDef4',
                            'I1', 'I2', 'I3', 'I4',
                            'C1', 'C2', 'C3', 'C4',
                            'BP1', 'BP2', 'BP3', 'BP4'
                        )
                        ->firstOrFail();

        
        return $stats;
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

    public static function getPreviousMatch() {
        $previousMatch = Matchs::where('date_match', '<', Carbon::now())
                                ->join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                                ->orderBy('date_match', 'desc')
                                ->first();

        return $previousMatch;
    }
    public static function getNextMatch() {
        $nextMatch = Matchs::where('date_match', '>=', Carbon::now())
                            ->join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                            ->orderBy('date_match')
                            ->first();

        return $nextMatch;
    }

}
