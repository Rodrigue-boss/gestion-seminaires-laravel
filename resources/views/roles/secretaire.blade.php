@extends('layouts.app')

@section('content')
<h1>Bienvenue, Secrétaire</h1>
<p>Vous pouvez valider ou rejeter les séminaires proposés.</p>
<a href="{{ route('seminaires.index') }}"><button>Gérer les séminaires</button></a>

<h2>Liste des séminaires</h2>

    @foreach($seminaires as $seminaire)
        <div style="margin-bottom: 15px; border: 1px solid #ccc; padding: 10px;">
            <h4>{{ $seminaire->titre }}</h4>
            <p><strong>Date :</strong> {{ $seminaire->date }}</p>
            <p><strong>Statut :</strong> {{ $seminaire->statut }}</p>

            @if($seminaire->publie && !$seminaire->fichier)
                <a href="{{ route('seminaires.fichier.form', $seminaire->id) }}">
                    📎 Ajouter le fichier de présentation
                </a>
            @elseif($seminaire->fichier)
                ✅ Fichier déjà ajouté
            @endif
        </div>
    @endforeach
@endsection
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Se déconnecter</button>
</form>

