<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'votre_base_de_donnees';
$user = 'votre_utilisateur';
$pass = 'votre_mot_de_passe';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de la validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code_confirmation = $_POST['code_confirmation'];

    // Vérification du code de confirmation ici
    // Ajoutez la logique pour vérifier si le code correspond

    echo '<div class="container">';
    echo '<h2>Votre Parrainage est Confirmé</h2>';
    echo '<p>Merci pour votre soutien !</p>';
    echo '</div>';
}
?>