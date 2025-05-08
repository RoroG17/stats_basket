<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JoueurResource;
use App\Http\Controllers\MatchResource;
use App\Http\Controllers\AppController;

Route::resource('/joueurs', JoueurResource::class)->names('joueurs');
Route::resource('/matchs', MatchResource::class)->names('matchs');

Route::get('/', function () {
    return Inertia::render('joueurs');
});

Route::get('/espace-joueurs', function () {
    return Inertia::render('joueurs'); 
});

Route::get('/espace-joueurs/{id}', function () {
    return Inertia::render('joueur'); 
});

Route::get('/espace-matchs', function () {
    return Inertia::render('matchs'); 
});

Route::get('/espace-matchs/{id}', function () {
    return Inertia::render('match'); 
});

Route::get('/accueil', [AppController::class, 'getPreviousNextMatchs'])->name('matchs.previous-next');