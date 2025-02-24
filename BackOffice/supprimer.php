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

// Vérifier si le numéro d'électeur a été envoyé
if (isset($_POST['numero_electeur'])) {
    $numero_electeur = $_POST['numero_electeur'];

    // Préparer et exécuter la requête de suppression
    $sql = "DELETE FROM candidats WHERE numero_electeur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $numero_electeur);

    if ($stmt->execute()) {
        echo "Candidat supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du candidat: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Numéro d'électeur non spécifié.";
}

$conn->close();

// Redirection vers la liste des candidats après la suppression
header("Location: listeC.php");
exit();
?>