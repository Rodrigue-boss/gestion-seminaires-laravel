<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
    <title>Séminaires</title>
</head>
<body>
    <h2>Liste des séminaires</h2>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Salle</th>
                <th>Présentateur</th>
                <th>Statut</th>
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
                    <td>{{ $seminaire->statut }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
