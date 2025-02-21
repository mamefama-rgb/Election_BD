<?php
session_start(); // Démarrer la session
include 'db.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['numero_electeur'])) {
    header("Location: parrainage.php"); // Rediriger vers la page de connexion si non connecté
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des informations de l'électeur
$id_electeur = $_SESSION['numero_electeur'];
$stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ?");
$stmt->execute([$id_electeur]);
$electeur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifiez si l'électeur existe
if (!$electeur) {
    echo "Aucun électeur trouvé.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel - Parrainage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenue, <?php echo $electeur['nom']; ?> <?php echo $electeur['prenom']; ?></h2>
        <p>Voici vos informations :</p>
        <ul>
            <li><strong>Numéro de Carte d'Électeur :</strong> <?php echo $electeur['numero_electeur']; ?></li>
            <li><strong>Numéro de Carte d'Identité Nationale :</strong> <?php echo $electeur['cin']; ?></li>
            <li><strong>Date de Naissance :</strong> <?php echo $electeur['date_naissance']; ?></li>
            <li><strong>Bureau de Vote :</strong> <?php echo $electeur['bureau_vote']; ?></li>
            <li><strong>Téléphone :</strong> <?php echo $electeur['telephone']; ?></li>
            <li><strong>Email :</strong> <?php echo $electeur['email']; ?></li>
        </ul>

        <h3>Parrainer un Candidat</h3>
        <p>Pour parrainer un candidat, cliquez sur le bouton ci-dessous :</p>
        <form action="liste_candidats.php" method="get">
            <button type="submit">Parrainer un Candidat</button>
        </form>
    </div>
</body>
</html>