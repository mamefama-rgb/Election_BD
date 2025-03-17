<?php
// Connexion à la base de données
include 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération des dates du formulaire
$dateDebut = $_POST['date_debut'];
$dateFin = $_POST['date_fin'];

// Validation des dates
$aujourdHui = new DateTime();
$sixMois = (new DateTime())->modify('+6 months');

if ($dateDebut >= $dateFin) {
    die("La date de début doit être inférieure à la date de fin.");
}

if (new DateTime($dateDebut) < $sixMois) {
    die("La date de début doit être supérieure à 6 mois par rapport à aujourd'hui.");
}

// Enregistrement des dates dans la base de données
$query = "INSERT INTO dates_parrainages (date_debut, date_fin) VALUES (:date_debut, :date_fin)";
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':date_debut' => $dateDebut,
    ':date_fin' => $dateFin,
]);

// Affichage du message de succès avec un bouton retour
echo "
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Succès</title>
    <style>
        body {
            background-color: #e6f7ff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        h2 {
            color: #004080;
        }
        .btn {
            display: inline-block;
            background-color: #4da6ff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #3399ff;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Les dates ont été enregistrées avec succès !</h2>
        <a href='index.html' class='btn'>Retour</a>
    </div>
</body>
</html>
";
?>