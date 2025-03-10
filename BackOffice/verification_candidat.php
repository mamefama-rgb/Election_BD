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

// Récupérer le numéro de la carte d'électeur depuis le formulaire
$numero_carte_electeur = $_POST['numero_electeur'];

// Vérifier si le numéro existe dans la table `electeurs`
$sql_electeur = "SELECT * FROM electeurs WHERE numero_electeur = '$numero_carte_electeur'";
$result_electeur = $conn->query($sql_electeur);

if ($result_electeur->num_rows > 0) {
    // Le numéro existe dans la table `electeurs`
    // Afficher les informations de l'électeur
    $row = $result_electeur->fetch_assoc();
    echo "Candidat valide. Informations de l'électeur :<br>";
    echo "Nom : " . $row['nom'] . "<br>";
    echo "Prénom : " . $row['prenom'] . "<br>";
    echo "Date de naissance : " . $row['date_naissance'] . "<br>";

    // Rediriger vers le formulaire de saisie des informations complémentaires
    header("Location: formulaire_candidat.php?numero_electeur=$numero_carte_electeur");
    exit();
} else {
    // Le numéro n'existe pas dans la table `electeurs`
    echo "L'électeur considéré n'est pas présent dans le fichier électoral.";
}

$conn->close();
?>