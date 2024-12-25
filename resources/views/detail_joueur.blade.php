<div>
    {{ $infoJoueur }}

    <table>
        <thead>
            <tr>
                <th>Journée</th>
                <th>Equipe</th>
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
            @foreach($statsJoueur as $stat)
                <tr>
                    <td>{{ $stat->numero }}</td>
                    <td>{{ $stat->nom }}</td>
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
