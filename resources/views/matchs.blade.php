@extends('template')

@section('title', 'Espace Matchs')

@section('content')
    <h1>Calendrier</h1>
    @foreach ($matchs as $match)
        <a href="#">
            <div class="carte">
                <p>Journée {{$match->numero}} ({{ $match->date_match }})<p>
                @if ($match->domicile == "1")
                <p>
                <img src="{{ asset('storage/logo_frouzins.png') }}" alt="Logo Frouzins"> Frouzins AC {{ $match->score_f }} VS {{ $match->score_a }} {{ $match->nom }} <img src="{{ asset('storage/' . $match->logo) }}" alt='Logo Equipe Adverse'>
                </p>

                @else
                    <p><img src="{{ asset('storage/' . $match->logo) }}" alt='Logo Equipe Adverse'> {{$match->nom}} {{ $match->score_a }} VS {{ $match->score_f }} Frouzins AC <img src="{{ asset('storage/logo_frouzins.png') }}" alt="Logo Frouzins"><p>
                @endif
            </div>
        </a>
    @endforeach
@endsection