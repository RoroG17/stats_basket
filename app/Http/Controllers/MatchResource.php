<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matchs;

class MatchResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matchs = Matchs::getAllMatchs();
        return $matchs;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): array
    {
        $infoMatch = Matchs::getInfoMatch($id);
        $statsMatch = Matchs::getStatsMatch($id);
        $statsEquipe = Matchs::getStatsEquipeMatch($id);

        return [
            'infoMatch' => $infoMatch,
            'statsMatch' => $statsMatch,
            'statsEquipe' => $statsEquipe,
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
