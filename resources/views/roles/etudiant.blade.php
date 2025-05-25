@extends('layouts.app')

@section('content')
<h1>Bienvenue, Étudiant</h1>
<p>Vous pouvez consulter les séminaires acceptés.</p>
<a href="{{ route('etudiant.seminaires') }}"><button>Voir les séminaires</button></a>

<h2>Séminaires disponibles</h2>

    @foreach($seminaires as $seminaire)
        @if($seminaire->publie)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
                <h4>{{ $seminaire->titre }}</h4>
                <p><strong>Date :</strong> {{ $seminaire->date }} à {{ $seminaire->heure_debut }}</p>
                <p><strong>Résumé :</strong> {{ $seminaire->resume }}</p>

                @if($seminaire->fichier)
                    <a href="{{ asset('storage/' . $seminaire->fichier) }}" target="_blank">
                        📄 Télécharger la présentation
                    </a>
                @else
                    <em>Fichier non encore disponible</em>
                @endif
            </div>
        @endif
    @endforeach
@endsection
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Se déconnecter</button>
</form>

