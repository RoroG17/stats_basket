<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matchs;

class AppController extends Controller
{
    
    public function getPreviousNextMatchs ()
    {
        $previousMatch = Matchs::getPreviousMatch();
        $nextMatch = Matchs::getNextMatch();
        return [
            'previousMatch' => $previousMatch,
            'nextMatch' => $nextMatch
        ];
    }
}
