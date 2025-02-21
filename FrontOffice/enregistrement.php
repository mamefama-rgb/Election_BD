<?php
session_start(); // Démarrer la session
require 'db.php'; // Inclusion du fichier de connexion à la base de données

// Initialisation des variables
$message = '';
$code_auth = null;

// Traitement du formulaire d'authentification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'authentification') {
    $numero_electeur = $_POST['numero_electeur'];
    $numero_cin = $_POST['cin'];

    // Vérification de la cohérence des informations
    if (empty($numero_electeur) || empty($numero_cin)) {
        $message = "Veuillez remplir toutes les informations.";
    } else {
        // Vérifier si l'électeur existe
        $stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ? AND cin = ?");
        $stmt->execute([$numero_electeur, $numero_cin]);
        $electeur_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$electeur_info) {
            $message = "Informations d'identification incorrectes.";
        } else {
            // Génération du code d'authentification
            $code_auth = random_int(100000, 999999);

            // Enregistrer le code d'authentification dans la base de données
            $stmt = $pdo->prepare("UPDATE electeurs SET code = ? WHERE numero_electeur = ?");
            if ($stmt->execute([$code_auth, $numero_electeur])) {
                $message = "Votre code d'authentification est : <strong>$code_auth</strong><br>Veuillez le garder en sécurité pour pouvoir parrainer.";
                $_SESSION['code_auth'] = $code_auth; // Stocker le code dans la session
                $_SESSION['numero_electeur'] = $numero_electeur; // Stocker le numéro d'électeur dans la session
            } else {
                $message = "Erreur lors de l'enregistrement du code d'authentification.";
            }
        }
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
    /* Styles existants ici */
</style>
<body>
    <div class="container">
        <h2>Enregistrement du Parrainage</h2>

        <form action="" method="post">
            <input type="hidden" name="action" value="authentification">
            <label for="numero_electeur">Numéro de Carte d'Électeur :</label>
            <input type="text" name="numero_electeur" required>

            <label for="cin">Numéro de Carte d'Identité Nationale :</label>
            <input type="text" name="cin" required>

            <button type="submit">Obtenir le Code</button>
        </form>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
            <?php if ($code_auth): ?>
                <form action="enre_parrainage.php" method="post">
                    <input type="hidden" name="action" value="continuer">
                    <button type="submit">Continuer</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>