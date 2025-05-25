@extends('layouts.app')

@section('content')
<h1>Bienvenue, Secrétaire</h1>
<p>Vous pouvez valider ou rejeter les séminaires proposés.</p>
<a href="{{ route('seminaires.index') }}"><button>Gérer les séminaires</button></a>
@endsection
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Se déconnecter</button>
</form>

