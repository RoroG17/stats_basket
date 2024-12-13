<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jouer extends Model
{
    use HasFactory;

    protected $table = 'jouer'; // Nom de la table
    protected $primaryKey = null; // Pas de clé primaire auto-incrémentée
    public $incrementing = false; // Clé primaire composite

    protected $fillable = [
        'Id_Match_Basket',
        'licence',
        'passe_decisive',
        'rebond_def',
        'rebond_off',
        'interception',
        'contre',
        'ballon_perdu',
        'tir_reussi',
        'tir_rate',
        'three_points_reussi',
        'three_points_rate',
        'passe_reussi',
        'passe_rate',
        'lf_reussi',
        'lf_rate',
        'faute',
        'minutes',
    ];
}
