<?php
session_start(); // Démarrer la session
require 'db.php'; // Inclusion du fichier de connexion à la base de données

// Initialisation des variables
$message = '';
$electeur_info = null;
$candidats = [];

// Étape 1 : Traitement du formulaire d'identification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'identification') {
    $numero_electeur = $_POST['numero_electeur'];
    $numero_cin = $_POST['cin'];

    // Vérification de la cohérence des informations
    if (empty($numero_electeur) || empty($numero_cin)) {
        $message = "Veuillez remplir toutes les informations.";
    } else {
        // Récupérer les informations de l'électeur
        $stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ? AND cin = ?");
        $stmt->execute([$numero_electeur, $numero_cin]);
        $electeur_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$electeur_info) {
            $message = "Informations d'identification incorrectes.";
        }
    }
}

// Étape 2 : Traitement du code d'authentification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'code') {
    // Ici, nous n'effectuons plus de vérification du code d'authentification
    // Récupérer la liste des candidats
    $stmt = $pdo->query("SELECT * FROM candidats");
    $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Étape 3 : Traitement du choix du candidat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'choisir_candidat') {
    $candidat_id = $_POST['id_candidat'];
    $verification_code = random_int(10000, 99999); // Générer un code de vérification

    // Stocker le choix dans la session pour validation ultérieure
    $_SESSION['choix_candidat'] = $candidat_id;
    $_SESSION['verification_code'] = $verification_code;

    // Afficher le code de vérification
    $message = "Votre code de vérification est : <strong>$verification_code</strong>";
}

// Étape 4 : Validation du choix
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'valider_choix') {
    $code_recu = $_POST['code_recu'];

    if ($code_recu == $_SESSION['verification_code']) {
        // Enregistrement du parrainage
        $stmt = $pdo->prepare("INSERT INTO parrainages (numero_electeur, id_candidat) VALUES (?, ?)");
        $stmt->execute([$electeur_info['numero_electeur'], $_SESSION['choix_candidat']]); // Assurez-vous que vous utilisez l'ID de l'électeur
        
        $message = "Votre parrainage a été enregistré avec succès.";
        // Optionnel: Réinitialiser les sessions
        session_unset();
        session_destroy();
    } else {
        $message = "Le code de vérification est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement du Parrainage</title>
    <link rel="stylesheet" href="styl.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    
    .container {
        max-width: 770px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
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
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        text-align: left;
    }
    table {
        margin: 20px 0;
    }
</style>
<body>
    <div class="container">
        <h2>Enregistrement du Parrainage</h2>

        <?php if (empty($electeur_info)): ?>
            <!-- Étape 1 : Formulaire d'identification -->
            <form action="" method="post">
                <input type="hidden" name="action" value="identification">
                <label for="numero_electeur">Numéro de Carte d'Électeur :</label>
                <input type="text" name="numero_electeur" required>

                <label for="cin">Numéro de Carte d'Identité Nationale :</label>
                <input type="text" name="cin" required>

                <button type="submit">Valider</button>
            </form>
        <?php elseif (empty($candidats)): ?>
            <!-- Étape 2 : Afficher les informations de l'électeur et saisir le code d'authentification -->
            <h3>Bienvenue, <?php echo htmlspecialchars($electeur_info['nom']); ?></h3>
            <p>Date de Naissance : <?php echo htmlspecialchars($electeur_info['date_naissance']); ?></p>
            <p>Bureau de Vote : <?php echo htmlspecialchars($electeur_info['bureau_vote']); ?></p>

            <form action="" method="post">
                <input type="hidden" name="action" value="code">
                <label for="code">Code d'Authentification :</label>
                <input type="text" name="code" required>

                <button type="submit">Valider le Code</button>
            </form>
        <?php else: ?>
            <!-- Étape 3 : Choix du candidat -->
            <h3>Choisissez un Candidat</h3>
            <form action="" method="post">
                <input type="hidden" name="action" value="choisir_candidat">
                <?php foreach ($candidats as $candidat): ?>
                    <div style="margin-bottom: 15px;">
                        <input type="radio" name="id_candidat" value="<?php echo $candidat['id_candidat']; ?>" required>
                        <label>
                            <img src="<?php echo htmlspecialchars($candidat['photo']); ?>" alt="<?php echo htmlspecialchars($candidat['nom']); ?>" 
                                 style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle; border-radius: 4px;">
                            <?php echo htmlspecialchars($candidat['nom']); ?> - <?php echo htmlspecialchars($candidat['slogan']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit">Choisir le Candidat</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_SESSION['verification_code'])): ?>
            <!-- Étape 4 : Validation du choix -->
            <h3>Validation du Choix</h3>
            <form action="" method="post">
                <input type="hidden" name="action" value="valider_choix">
                <label for="code_recu">Entrez le Code de Vérification :</label>
                <input type="text" name="code_recu" required>

                <button type="submit">Valider</button>
            </form>
        <?php endif; ?>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>