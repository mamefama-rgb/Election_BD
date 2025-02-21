<?php
session_start(); // Démarrer la session

include 'db.php';  

// Initialisation des variables
$message = '';
$candidat = null;

// Vérification de l'authentification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'authentifier') {
    $email = $_POST['email'];
    $code_auth = $_POST['code'];

    // Vérification des informations du candidat
    $stmt = $pdo->prepare("SELECT * FROM candidats WHERE email = ? AND code = ?");
    $stmt->execute([$email, $code_auth]);
    $candidat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$candidat) {
        $message = "Informations d'authentification incorrectes.";
    }
}

// Récupération des parrainages si le candidat est authentifié
$parrainages = [];
if ($candidat) {
    $stmt = $pdo->prepare("SELECT date_parrainage, COUNT(*) as total FROM parrainages WHERE id_candidat = ? GROUP BY date_parrainage ORDER BY date_parrainage DESC");
    $stmt->execute([$candidat['id']]);
    $parrainages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Parrainages</title>
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
        max-width: 500px;
        margin: auto;
        background-color: #ccc;
        padding: 20px;
        border-radius: 20px;
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



    body {
    font-family: Arial, sans-serif; /* Police par défaut */
    margin: 0; /* Supprimer les marges par défaut */
}

/* Styles pour l'en-tête */
header {
    background-color:rgb(208, 212, 217); 
    padding: 10px 0; 
}

/* Styles pour la barre de navigation */
.navbar {
    display: flex; /* Utiliser flexbox pour aligner les éléments */
    justify-content: right; /* Centrer les éléments horizontalement */
}

/* Styles pour les liens de navigation */
.navbar a {
    color:black; /* Couleur du texte */
    text-decoration: none; /* Pas de soulignement */
    padding: 15px 20px; /* Espacement autour des liens */
    transition: background-color 0.3s; 
    font-size: 20px; /* Taille du texte */
}

.navbar a:hover {
    background-color:rgb(144, 150, 144); /* Couleur au survol */
    border-radius: 5px; /* Coins arrondis au survol */
}

    </style>


<header>
<h1>DGE</h1>
    <nav class="navbar">
    
        <div class="contain">
            <b>
            <a href="accueil.html">Accueil</a>
            <a href="ouverture_parrainage.php">Date</a></b>

        </div>

    </nav>
</header>

<br><br><br><br>


<body>
    <div class="container">
        <h2>Suivi des Parrainages</h2>

        <?php if (!$candidat): ?>
            <form action="suivi_parrainage.php" method="post">
                <label for="email">Adresse Email :</label>
                <input type="email" name="email" required>

                <label for="code">Code d'Authentification :</label>
                <input type="text" name="code" required>

                <button type="submit">Se Connecter</button>
            </form>
            <?php if ($message): ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>
        <?php else: ?>
            <h3>Bienvenue, <?php echo htmlspecialchars($candidat['nom']); ?></h3>
            <h4>Évolution de vos Parrainages :</h4>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nombre de Parrainages</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($parrainages): ?>
                        <?php foreach ($parrainages as $parrainage): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($parrainage['date_parrainage']); ?></td>
                                <td><?php echo htmlspecialchars($parrainage['total']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Aucun parrainage enregistré.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>