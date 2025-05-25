@extends('layouts.app')

@section('content')
    <h2>Envoyer ou modifier le résumé</h2>

    @if(session('error'))
        <div style="color:red">{{ session('error') }}</div>
    @endif

    <form action="{{ route('seminaires.resume.update', $seminaire->id) }}" method="POST">
        @csrf
        <label for="resume">Résumé :</label><br>
        <textarea name="resume" rows="6">{{ old('resume', $seminaire->resume) }}</textarea><br>

        <button type="submit">Enregistrer le résumé</button>
    </form>
@endsection
