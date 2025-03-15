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
    

    public static function getInfoJoueur($licence) {
        $joueur = Joueur::findOrFail($licence);
        return $joueur;
    }

    public static function getStatsJoueur($licence) {
        $stats = Jouer::join('matchs', 'jouer.Id_Match_Basket', '=', 'matchs.Id_Match')
                        ->join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                        ->select('*', DB::raw('jouer.rebond_off + jouer.rebond_def AS rebond'), DB::raw('jouer.tir_reussi * 2 + jouer.three_points_reussi * 3 + jouer.lf_reussi AS points'))
                        ->where('jouer.licence', '=', $licence)
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
}
