<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Soumission d’un séminaire</title>
</head>
<body>
    <h1>Soumettre un séminaire</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('seminaires.store') }}">
        @csrf
        <label>Titre :</label><br>
        <input type="text" name="titre" required><br><br>

        <label>Résumé :</label><br>
        <textarea name="resume" required></textarea><br><br>

        <label>Date :</label><br>
        <input type="date" name="date" required><br><br>

        <label>Heure de début :</label><br>
        <input type="time" name="heure_debut" required><br><br>

        <label>Heure de fin :</label><br>
        <input type="time" name="heure_fin" required><br><br>

        <label>Salle :</label><br>
        <input type="text" name="salle" required><br><br>

        <label>Lien visio (facultatif) :</label><br>
        <input type="url" name="lien_visio"><br><br>

        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
