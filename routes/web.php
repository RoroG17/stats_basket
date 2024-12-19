<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JoueurResource;
use App\Http\Controllers\MatchResource;

Route::get('/', function () {
    return Inertia('App');
});

Route::resource('/joueurs', JoueurResource::class);
Route::resource('/matchs', MatchResource::class);