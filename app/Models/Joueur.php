<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return Joueur::all();
    }

    public static function getInfoJoueur($licence) {
        $joueur = Joueur::findOrFail($licence);
        return $joueur;
    }

    public static function getStatsJoueur($licence) {
        $stats = Jouer::join('matchs', 'jouer.Id_Match_Basket', '=', 'matchs.Id_Match')
                        ->join('equipes', 'matchs.Id_Equipe', '=', 'equipes.Id_Equipe')
                        ->where('jouer.licence', '=', $licence)
                        ->get();
        return $stats;
    }
}
