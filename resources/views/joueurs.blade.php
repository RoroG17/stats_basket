@extends('template')

@section('title', 'Espace Matchs')

@section('content')
    <h1>Effectif</h1>
    @foreach ($joueurs as $joueur)
        <a href="{{ route('joueurs.show', ['joueur' => $joueur->licence]) }}">
            <div class="carte">
                <p>{{ $joueur->nom }} {{$joueur->prenom}}</p>
            </div>
        </a>
    @endforeach
@endsection