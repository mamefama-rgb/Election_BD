<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification des Informations d'Authentification</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    
    .container {
        max-width: 900px;
        margin: auto;
        background-color: #ccc;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    h1, h2 {
        color: #333;
    }
    
    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    button {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    button:hover {
        background-color: #218838;
    }</style>
<body>
    <div class="container">
        <h2>Vérifiez vos Informations</h2>
        <form action="verifier.php" method="post" id="verificationForm">
            <label for="numero_electeur">Numéro de Carte d'Électeur :</label>
            <input type="text" id="numero_electeur" name="numero_electeur" required>

            <label for="numero_cin">Numéro de Carte d'Identité Nationale :</label>
            <input type="text" id="cin" name="cin" required>

            <label for="nom">Nom de Famille :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="bureau_vote">Numéro de Bureau de Vote :</label>
            <input type="text" id="bureau_vote" name="bureau_vote" required>

            <button type="submit">Vérifier</button>
        </form>
    </div>
</body>
</html>