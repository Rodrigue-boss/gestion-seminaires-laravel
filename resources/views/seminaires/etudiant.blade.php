@extends('layouts.app')

@section('content')
    <h1>Séminaires acceptés</h1>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Salle</th>
                <th>Présentateur</th>
                <th>Lien visio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminaires as $seminaire)
                <tr>
                    <td>{{ $seminaire->titre }}</td>
                    <td>{{ $seminaire->date }}</td>
                    <td>{{ $seminaire->heure_debut }} - {{ $seminaire->heure_fin }}</td>
                    <td>{{ $seminaire->salle }}</td>
                    <td>{{ $seminaire->user->name }}</td>
                    <td>
                        @if($seminaire->lien_visio)
                            <a href="{{ $seminaire->lien_visio }}" target="_blank">Lien</a>
                        @else
                            Aucun
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
