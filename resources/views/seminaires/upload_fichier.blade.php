@extends('layouts.app')

@section('content')
    <h2>Ajouter le fichier de présentation</h2>

    <form action="{{ route('seminaires.fichier.upload', $seminaire->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="fichier">Fichier (.pdf, .ppt, .pptx) :</label><br>
        <input type="file" name="fichier" required><br><br>
        <button type="submit">Uploader</button>
    </form>
@endsection
