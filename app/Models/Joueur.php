<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
}
