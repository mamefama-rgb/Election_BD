<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Nom d'utilisateur par défaut de WAMP
$password = ""; // Mot de passe par défaut de WAMP (vide)
$dbname = "gestparrainage"; // Remplacez par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer le numéro de l'électeur depuis l'URL
$numero_carte_electeur = $_GET['numero_electeur'];

// Récupérer les informations du candidat
$sql = "SELECT * FROM candidats WHERE numero_electeur = '$numero_carte_electeur'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Détails du candidat</title>
        <link rel="stylesheet" href="details.css"> <!-- Lien vers le fichier CSS -->
    </head>
    <body>
        <div class="container">
            <h1>Informations du candidat</h1>
            <div class="details-columns">
                <div class="details-column">
                    <p><strong>Nom :</strong> ' . $row['nom'] . '</p>
                    <p><strong>Prénom :</strong> ' . $row['prenom'] . '</p>
                    <p><strong>Email :</strong> ' . $row['email'] . '</p>
                    <p><strong>Téléphone :</strong> ' . $row['telephone'] . '</p>
                    <p><strong>Date de naissance :</strong> ' . $row['date_naissance'] . '</p>
                </div>
                <div class="details-column">
                    <p><strong>Parti politique :</strong> ' . $row['parti_politique'] . '</p>
                    <p><strong>Slogan :</strong> ' . $row['slogan'] . '</p>
                    <p><strong>Couleurs :</strong> ' . $row['couleurs'] . '</p>
                    <p><strong>URL de la page :</strong> <a href="' . $row['url_information'] . '">' . $row['url_information'] . '</a></p>
                </div>
            </div>
            <p><strong>Photo :</strong></p>
            <img src="' . $row['photo'] . '" alt="Photo du candidat" width="150" height="100">

            <!-- Bouton pour générer un code -->
            <form action="code.php" method="post">
                <input type="hidden" name="numero_electeur" value="' . $row['numero_electeur'] . '">
                <input type="submit" value="Générer un code">
            </form>

            <!-- Bouton Retour -->
            <button class="back-button" onclick="window.history.back();">Retour</button>
        </div>
    </body>
    </html>';
} else {
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Détails du candidat</title>
        <link rel="stylesheet" href="details.css"> <!-- Lien vers le fichier CSS -->
    </head>
    <body>
        <div class="container">
            <p>Candidat non trouvé.</p>
            <!-- Bouton Retour -->
            <button class="back-button" onclick="window.history.back();">Retour</button>
        </div>
    </body>
    </html>';
}

$conn->close();
?>