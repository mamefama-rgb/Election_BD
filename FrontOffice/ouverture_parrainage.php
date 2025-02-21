<?php
session_start(); // Démarrer la session

include 'db.php';

// Initialisation des variables
$message = '';
$date_debut = '';
$date_fin = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Vérification des dates
    $date_now = new DateTime();
    $date_debut_obj = new DateTime($date_debut);
    $date_fin_obj = new DateTime($date_fin);

    if ($date_debut_obj < $date_now) {
        $message = "La date de début doit être supérieure à la date actuelle.";
    } elseif ($date_debut_obj >= $date_fin_obj) {
        $message = "La date de début doit être inférieure à la date de fin.";
    } elseif ($date_debut_obj < (clone $date_now)->modify('+6 months')) {
        $message = "La date de début doit être supérieure à 6 mois par rapport à la date actuelle.";
    } else {
        // Enregistrement dans la base de données
        $stmt = $pdo->prepare("INSERT INTO dates (date_debut, date_fin) VALUES (?, ?)");
        $stmt->execute([$date_debut, $date_fin]);
        $message = "Les dates de parrainage ont été enregistrées avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ouverture de la Période de Parrainage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Ouverture de la Période de Parrainage</h2>
        <form action="" method="post">
            <label for="date_debut">Date de Début :</label>
            <input type="date" name="date_debut" required value="<?php echo htmlspecialchars($date_debut); ?>">

            <label for="date_fin">Date de Fin :</label>
            <input type="date" name="date_fin" required value="<?php echo htmlspecialchars($date_fin); ?>">

            <button type="submit">Enregistrer les Dates</button>
        </form>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>