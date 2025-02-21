<?php
session_start(); // Démarrer la session
require 'db.php'; // Inclusion du fichier de connexion à la base de données

$message = '';

// Étape 3 : Traitement du choix du candidat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'choisir_candidat') {
    $candidats_ids = $_POST['id_candidats']; // Récupérer les IDs des candidats sélectionnés
    $verification_code = random_int(10000, 99999); // Générer un code de vérification

    // Stocker le choix dans la session pour validation ultérieure
    $_SESSION['choix_candidats'] = $candidats_ids; // Enregistrer tous les IDs sélectionnés
    $_SESSION['verification_code'] = $verification_code;

    $message = "Votre code de vérification est : <strong>$verification_code</strong>";
}

// Récupérer la liste des candidats
$stmt = $pdo->query("SELECT * FROM candidats");
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Candidat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%; /* Pour que le tableau prenne toute la largeur */
            border-collapse: collapse; /* Pour éviter le double bord */
            margin: 20px 0; /* Ajoute de l'espace au-dessus et en dessous du tableau */
        }
        th, td {
            padding: 15px; /* Espace dans les cellules */
            border: 1px solid #ddd; /* Bordure légère */
        }
        th {
            background-color: #f2f2f2; /* Couleur de fond des en-têtes */
            text-align: left; /* Alignement à gauche */
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Choisissez des Candidats à Parrainer</h2>
    
    <form action="validation.php" method="post">
        <input type="hidden" name="action" value="choisir_candidat">
        <div class="container">
            <h2>Liste des Candidats Enregistrés</h2>
            <table>
                <tr>
                    <th>Sélectionner</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Parti</th>
                </tr>
                <?php foreach ($candidats as $candidat): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="id_candidats[]" value="<?php echo $candidat['id_candidat']; ?>">
                        </td>
                        <td><?php echo htmlspecialchars($candidat['nom']); ?></td>
                        <td><?php echo htmlspecialchars($candidat['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($candidat['parti_politique']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
            </table>
            <button type="submit">Choisir les Candidats</button>
        </div>
    </form>
</body>
</html>