<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <p>Bonjour {{ $seminaire->user->name }},</p>

    <p>Votre demande de présentation de séminaire intitulée :</p>

    <strong>{{ $seminaire->titre }}</strong>

    <p>a été validée. Elle est programmée pour le :</p>

    <strong>{{ $seminaire->date }} à {{ $seminaire->heure_debut }}</strong><br>

    <p>Merci de préparer votre présentation.</p>

    <p>Cordialement,<br>Plateforme Séminaires IMSP</p>
</body>
</html>
