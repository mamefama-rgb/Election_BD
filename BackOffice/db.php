<?php
$servername = "localhost";
$username = "root"; // Nom d'utilisateur par défaut de WAMP
$password = ""; // Mot de passe par défaut de WAMP (vide)
$dbname = "gestparrainage"; // Remplacez par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>