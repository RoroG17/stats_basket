<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use App\Models\Jouer;


class Joueur extends Model
{
    use HasFactory;

    protected $table = 'joueurs'; // Nom de la table
    protected $primaryKey = 'licence'; // Clé primaire
    public $incrementing = false; // La clé primaire n'est pas auto-incrémentée
    protected $keyType = 'string'; // Type de la clé primaire

    protected $fillable = [
        'licence',
        'nom',
        'prenom',
        'date_naissance',
    ];

    public static function getAll() {
        return Joueur::orderBy('nom')->orderBy('prenom')->get();
    }

    public static function getAllStatsMoy() {
        $stats = Jouer::selectRaw('
                            AVG(jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi) AS Points,
                            AVG(jouer.passe_decisive) AS Passe_Decisive,
                            AVG(jouer.rebond_off + jouer.rebond_def) AS Rebonds,
                            AVG(jouer.rebond_def) AS Rebond_def,
                            AVG(jouer.rebond_off) AS Rebond_off,
                            AVG(jouer.interception) AS Interception,
                            AVG(jouer.contre) AS Contre,
                            AVG(jouer.ballon_perdu) AS Ballon_Perdu,
                            AVG(jouer.faute) AS Faute
                        ')
                        ->first(); 
        return $stats;   
    }
    

    public static function getInfoJoueur($licence) {
        $joueur = Joueur::findOrFail($licence);
        return $joueur;
    }

    public static function getStatsJoueur($licence) {
        $stats = Jouer::join('matchs', 'jouer.Id_Match_Basket', '=', 'matchs.Id_Match')
                      ->join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                      ->select(
                          '*',
                          DB::raw('jouer.rebond_off + jouer.rebond_def AS rebond'),
                          DB::raw('jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi AS points'),
                          DB::raw('ROUND((
                              (jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi) * 2 + 
                              (jouer.passe_decisive * 1.5) + 
                              ((jouer.rebond_off + jouer.rebond_def) * 1.2) + 
                              (jouer.interception * 2) + 
                              (jouer.contre * 2) +
                              (jouer.passe_reussi * 0.5) -
                              (jouer.ballon_perdu * 1) - 
                              ((jouer.tir_rate + jouer.three_points_rate + jouer.lf_rate) * 0.5)
                          ) / 8.7 + 3, 1) AS note') // Calcul de la note normalisée
                      )
                      ->where('jouer.licence', '=', $licence)
                      ->orderBy('matchs.date_match')
                      ->get();
        return $stats;
    }

    public static function getStatsMoyJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                        ->selectRaw('
                            AVG(jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi) AS Points,
                            AVG(jouer.passe_decisive) AS Passe_Decisive,
                            AVG(jouer.rebond_off + jouer.rebond_def) AS Rebonds,
                            AVG(jouer.rebond_def) AS Rebond_def,
                            AVG(jouer.rebond_off) AS Rebond_off,
                            AVG(jouer.interception) AS Interception,
                            AVG(jouer.contre) AS Contre,
                            AVG(jouer.ballon_perdu) AS Ballon_Perdu,
                            AVG(jouer.faute) AS Faute
                        ')
                        ->first(); 
        return $stats;   
    }

    public static function getStatsMoyShootJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                        ->selectRaw('
                            SUM(jouer.tir_reussi + jouer.three_points_reussi) AS Tir_Réussis,
                            SUM(jouer.tir_rate + jouer.three_points_rate) AS Tir_Ratés
                        ')
                        ->first(); 
        return $stats;   
    }

    public static function getStatsMoyLFJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                        ->selectRaw('
                            SUM(jouer.lf_reussi) AS LF_Réussis,
                            SUM(jouer.lf_rate) AS LF_Ratés
                        ')
                        ->first(); 
        return $stats;   
    }


    public static function getImplicationJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                    ->select(DB::raw('AVG(passe_decisive + rebond_def + rebond_off + interception + contre +  ballon_perdu + tir_reussi + tir_rate + three_points_reussi +
                                            three_points_rate + passe_reussi + passe_rate + lf_reussi + lf_rate + faute) as total'))
                    ->first();
        return $stats;
    }

    public static function getAllImplication()
    {
        $moyenne = Jouer::select(DB::raw('AVG(total_stats) as total'))
            ->from(function ($query) {
                $query->select(
                        'id_match_basket',
                        DB::raw('SUM(passe_decisive + rebond_def + rebond_off + interception + contre + ballon_perdu + tir_reussi + tir_rate + three_points_reussi + three_points_rate + passe_reussi + passe_rate + lf_reussi + lf_rate + faute) as total_stats')
                    )
                    ->from('jouer')
                    ->groupBy('id_match_basket');
            }, 'match_stats')
            ->first();

        return $moyenne;
    }

    public static function getImplicationPositiveJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                    ->select(DB::raw('AVG(passe_decisive + rebond_def + rebond_off + interception + contre + tir_reussi + three_points_reussi + passe_reussi + lf_reussi) as total'))
                    ->first();
        return $stats;
    }

    public static function getAllImplicationPositive()
    {
        $moyenne = Jouer::select(DB::raw('AVG(total_stats) as total'))
            ->from(function ($query) {
                $query->select(
                        'id_match_basket',
                        DB::raw('SUM(passe_decisive + rebond_def + rebond_off + interception + contre + tir_reussi + three_points_reussi + passe_reussi + lf_reussi) as total_stats')
                    )
                    ->from('jouer')
                    ->groupBy('id_match_basket');
            }, 'match_stats')
            ->first();

        return $moyenne;
    }

    public static function getImplicationNegativeJoueur($licence) {
        $stats = Jouer::where('jouer.licence', '=', $licence)
                    ->select(DB::raw('AVG(ballon_perdu + tir_rate + three_points_rate + passe_rate + lf_rate + faute) as total'))
                    ->first();
        return $stats;
    }

    public static function getAllImplicationNegative()
    {
        $moyenne = Jouer::select(DB::raw('AVG(total_stats) as total'))
            ->from(function ($query) {
                $query->select(
                        'id_match_basket',
                        DB::raw('SUM(ballon_perdu + tir_rate + three_points_rate + passe_rate + lf_rate + faute) as total_stats')
                    )
                    ->from('jouer')
                    ->groupBy('id_match_basket');
            }, 'match_stats')
            ->first();

        return $moyenne;
    }


}
