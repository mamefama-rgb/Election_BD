<?php
session_start();

include 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// Requête pour vérifier les identifiants
$query = "SELECT * FROM admins WHERE username = :username AND password = :password";

$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $username, 'password' => $password]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    // Si les identifiants sont corrects, rediriger vers index.php
    header('Location: index.php');
    exit(); // Assurez-vous de terminer le script après la redirection
} else {
    // Si les identifiants sont incorrects, afficher un message d'erreur
    echo "Identifiants incorrects. Veuillez réessayer.";
    // Vous pouvez également rediriger vers une page de connexion avec un message d'erreur
    // header('Location: login.php?error=1');
    // exit();
}
?>