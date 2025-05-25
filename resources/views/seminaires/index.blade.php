<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des séminaires</title>
</head>
<body>
    <h1>Séminaires soumis</h1>
    <form method="GET" action="{{ route('seminaires.index') }}">
    <label for="statut">Filtrer par statut :</label>
    <select name="statut" id="statut">
        <option value="">-- Tous --</option>
        <option value="en attente" {{ $filtre === 'en attente' ? 'selected' : '' }}>En attente</option>
        <option value="accepté" {{ $filtre === 'accepté' ? 'selected' : '' }}>Acceptés</option>
        <option value="rejeté" {{ $filtre === 'rejeté' ? 'selected' : '' }}>Rejetés</option>
    </select>

    <label for="search">Recherche :</label>
    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Titre, salle, présentateur">

    <button type="submit">Filtrer</button>
</form>

<br>

    <a href="{{ route('seminaires.export.pdf') }}" target="_blank">
       <button>Télécharger en PDF</button>
    </a>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Résumé</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Salle</th>
                <th>Présentateur</th>
                <th>Lien visio</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminaires as $seminaire)
                <tr>
                    <td>{{ $seminaire->titre }}</td>
                    <td>{{ $seminaire->resume }}</td>
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
                    <td>{{ $seminaire->statut }}</td>
                    <td>
                       @if(Auth::user()->role === 'secretaire')
                       @if($seminaire->statut === 'en attente')
                       <form action="{{ route('seminaires.valider', $seminaire->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit">Valider</button>
                       </form>

                       <form action="{{ route('seminaires.rejeter', $seminaire->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit">Rejeter</button>
                       </form>
                       @else
                      <em>Aucune action</em>
                        @endif
                         @else
                     <em>N/A</em>
                     @endif
                     @if($seminaire->statut === 'accepté' && !$seminaire->publie)
                     <form action="{{ route('seminaires.publier', $seminaire->id) }}" method="POST" style="margin-top: 5px;">
                       @csrf
                      <button type="submit">Publier</button>
                     </form>
                     @endif

                </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
