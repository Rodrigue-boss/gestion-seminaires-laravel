@extends('layouts.app')

@section('content')
<h1>Bienvenue, Présentateur</h1>
<p>Vous pouvez soumettre et consulter vos séminaires.</p>
<a href="{{ route('seminaires.create') }}"><button>Soumettre un séminaire</button></a>
<a href="{{ route('seminaires.index') }}"><button>Voir tous les séminaires</button></a>
@endsection
<h2>Mes séminaires validés</h2>
@foreach($seminaires as $seminaire)
    @if($seminaire->statut === 'accepté')
        <p>
            <strong>{{ $seminaire->titre }}</strong><br>
            Présentation prévue le {{ $seminaire->date }}<br>
            <a href="{{ route('seminaires.resume', $seminaire->id) }}">→ Envoyer / modifier résumé</a>
        </p>
    @endif
    @if($seminaire->publie && !$seminaire->fichier)
    <a href="{{ route('seminaires.fichier.form', $seminaire->id) }}">
        📎 Ajouter le fichier de présentation
    </a>
    @elseif($seminaire->fichier)
            <p>Fichier déjà ajouté ✅</p>
    @endif
@endforeach

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Se déconnecter</button>
</form>

