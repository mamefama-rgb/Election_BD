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

// Vérifier si un numéro d'électeur est bien envoyé
$code = ""; // Initialisation pour éviter l'erreur "Undefined variable"
if (isset($_POST['numero_electeur'])) {
    $numero_carte_electeur = $_POST['numero_electeur'];

    // Générer un code unique
    $code = substr(md5(uniqid(rand(), true)), 0, 8);

    // Enregistrer le code dans la base de données
    $sql = "UPDATE candidats SET code = '$code' WHERE numero_electeur = '$numero_carte_electeur'";

    if (!$conn->query($sql)) {
        $code = "Erreur lors de la génération du code.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Génération du Code</title>
    <link rel="stylesheet" href="code.css"> <!-- Lien vers le CSS -->
</head>
<body>
    <div class="container">
        <h1>Code de Parrainage</h1>
        <div class="code-box">
            <?php 
            if (!empty($code)) {
                echo "Code généré : <span>$code</span>";
            } else {
                echo "<p style='color:red;'>Aucun code généré. Vérifiez le numéro d'électeur.</p>";
            }
            ?>
        </div>
        <button onclick="window.location.href='index.html'">Retour</button>
    </div>
</body>
</html>