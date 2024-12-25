<div>
    <a href="{{ route('matchs.index') }}">Retour</a>
    <div class="carte">
        <p>Journée {{$infoMatch->numero}} ({{ $infoMatch->date_match }})<p>
        @if ($infoMatch->domicile == "1")
            <p>
                <img src="{{ asset('storage/logo_frouzins.png') }}" alt="Logo Frouzins"> Frouzins AC {{ $infoMatch->score_f }} VS {{ $infoMatch->score_a }} {{ $infoMatch->nom }} <img src="{{ asset('storage/' . $infoMatch->logo) }}" alt='Logo Equipe Adverse'>
            </p>

        @else
            <p><img src="{{ asset('storage/' . $infoMatch->logo) }}" alt='Logo Equipe Adverse'> {{$infoMatch->nom}} {{ $infoMatch->score_a }} VS {{ $infoMatch->score_f }} Frouzins AC <img src="{{ asset('storage/logo_frouzins.png') }}" alt="Logo Frouzins"><p>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Points</th>
                <th>Passe Décisive</th>
                <th>Rebonds</th>
                <th>Rebond Défensif</th>
                <th>Rebond Offensif</th>
                <th>Interception</th>
                <th>Contre</th>
                <th>Ballon Perdu</th>
                <th>Tir Réussi</th>
                <th>Tir Raté</th>
                <th>% Tir</th>
                <th>3pts Réussi</th>
                <th>3pts Raté</th>
                <th>% 3pts</th>
                <th>Passe Réussi</th>
                <th>Passe Raté</th>
                <th>LF Réussi</th>
                <th>LF Raté</th>
                <th>% LF</th>
                <th>Faute</th>
                <th>Minutes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statsMatch as $stat)
                <tr>
                    <td>{{ $stat->nom }}</td>
                    <td>{{ $stat->prenom }}</td>
                    <td>{{ ($stat->tir_reussi * 2) + ($stat->three_points_reussi * 3) + $stat->lf_reussi }}</td>
                    <td>{{ $stat->passe_decisive }}</td>
                    <td>{{ $stat->rebond_def + $stat->rebond_off }}</td>
                    <td>{{ $stat->rebond_def }}</td>
                    <td>{{ $stat->rebond_off }}</td>
                    <td>{{ $stat->interception }}</td>
                    <td>{{ $stat->contre }}</td>
                    <td>{{ $stat->ballon_perdu }}</td>
                    <td>{{ $stat->tir_reussi }}</td>
                    <td>{{ $stat->tir_rate }}</td>
                    <td>
                        @if($stat->tir_reussi + $stat->tir_rate > 0)
                            {{ round(($stat->tir_reussi / ($stat->tir_reussi + $stat->tir_rate)) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td>{{ $stat->three_points_reussi }}</td>
                    <td>{{ $stat->three_points_rate }}</td>
                    <td>
                        @if($stat->three_points_reussi + $stat->three_points_rate > 0)
                            {{ round(($stat->three_points_reussi / ($stat->three_points_reussi + $stat->three_points_rate)) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td>{{ $stat->passe_reussi }}</td>
                    <td>{{ $stat->passe_rate }}</td>
                    <td>{{ $stat->lf_reussi }}</td>
                    <td>{{ $stat->lf_rate }}</td>
                    <td>
                        @if($stat->lf_reussi + $stat->lf_rate > 0)
                            {{ round(($stat->lf_reussi / ($stat->lf_reussi + $stat->lf_rate)) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td>{{ $stat->faute }}</td>
                    <td>{{ $stat->minutes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
