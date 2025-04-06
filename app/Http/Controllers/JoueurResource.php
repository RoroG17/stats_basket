<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Joueur;
use Illuminate\Support\Facades\Log;


class JoueurResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $joueurs = Joueur::getAll(); 
        return $joueurs;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        console.log($request);
        return true;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $infoJoueur = Joueur::getInfoJoueur($id);
        $statsJoueur = Joueur::getStatsJoueur($id);
        $statsMoyJoueur = Joueur::getStatsMoyJoueur($id);
        $statsMoyAll = Joueur::getAllStatsMoy();
        $statsMoyShoot = Joueur::getStatsMoyShootJoueur($id);
        $statsMoyLF = Joueur::getStatsMoyLFJoueur($id);
        $statsImplicationJoueur = Joueur::getImplicationJoueur($id);
        $statsAllImplication = Joueur::getAllImplication();
        $statsImplicationPositiveJoueur = Joueur::getImplicationPositiveJoueur($id);
        $statsAllImplicationPositive = Joueur::getAllImplicationPositive();
        $statsImplicationNegativeJoueur = Joueur::getImplicationNegativeJoueur($id);
        $statsAllImplicationNegative = Joueur::getAllImplicationNegative();
        return [
            'infoJoueur' => $infoJoueur,
            'stats' => $statsJoueur,
            'statsMoy' => $statsMoyJoueur,
            'statsMoyAll' => $statsMoyAll,
            'statsShoot' => $statsMoyShoot,
            'statsLF' => $statsMoyLF,
            'statsImplicationJoueur' => $statsImplicationJoueur,
            'statsAllImplication' => $statsAllImplication,
            'statsImplicationPositiveJoueur' => $statsImplicationPositiveJoueur,
            'statsAllImplicationPositive' => $statsAllImplicationPositive,
            'statsImplicationNegativeJoueur' => $statsImplicationNegativeJoueur,
            'statsAllImplicationNegative' => $statsAllImplicationNegative
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
