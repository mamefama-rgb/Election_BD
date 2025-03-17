<?php
// Connexion à la base de données
include 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des candidats</title>
    <link rel="stylesheet" href="interface.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Saisie des candidats</h1>
        <form action="verification_candidat.php" method="post">
            <label for="numero_electeur">Numéro de la carte d'électeur :</label>
            <input type="text" id="numero_electeur" name="numero_electeur" required>
            <input type="submit" value="Vérifier">
        </form>
    </div>
</body>
</html>