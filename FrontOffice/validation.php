<?php
session_start(); // Démarrer la session
require 'db.php'; // Inclusion du fichier de connexion à la base de données

$message = '';

// Vérification si le parrainage a été enregistré
if (isset($_SESSION['parrainage_enregistre']) && $_SESSION['parrainage_enregistre']) {
    $message = "Votre parrainage a été enregistré avec succès pour " . htmlspecialchars($_SESSION['electeur_']['prenom']) . " " . htmlspecialchars($_SESSION['electeur_info']['nom']) . " (Numéro d'Électeur: " . htmlspecialchars($_SESSION['electeur_info']['numero_electeur']) . ")";
    session_unset(); // Réinitialiser les sessions
    session_destroy();
}
/*
// Enregistrement du parrainage (à appeler depuis l'autre page)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enregistrer_parrainage') {
    // Enregistrement du parrainage
    $stmt = $pdo->prepare("INSERT INTO parrainages (numero_electeur, id_candidat) VALUES (?, ?)");
    $stmt->execute([$_SESSION['electeur_info']['numero_electeur'], $_SESSION['choix_candidat']]);

    // Indiquer que le parrainage a été enregistré
    $_SESSION['parrainage_enregistre'] = true;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation du Choix</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        background-image: url(vote5.jpeg);
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
        
    header{
  padding-top: 1.5rem;
  background: transparent;
  box-shadow: 10px;
  .contain{
      display: flex;
      justify-content: space-between;
      box-shadow: 20px;
    

      /* logo */
      & img{
          max-width: 250px;
      }

      /* nav bar */
      & nav{
          display: flex; 
          gap: 5.5rem;
          box-shadow: 10px;

          /* manu items */
          & a{
              
              font-size:1.5rem;
              color: rgba(34,34,34);
              font-weight: 900;
              display: inline-block;

              /* contact manu */
              &:last-child{
                  padding-right: 1.5rem;
              }
          }
      }
  }
}

</style>
<body>

<header>
        <div class="contain">
            <h1>DGE</h1>
            <input type="checkbox" id="manu" hidden>
            <nav>
                <a href="accueil.html">Accueil</a>
                <a href="parrainage.php">Parrainer</a>
                <a href="date_parrainage.php">Date</a>
            </nav>
        </div></header>
        
<br><br><br><br><br>
</head>
<body>
    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>
    <div class="container">
    <h2>Validation du Choix</h2>
    <form action="" method="post">
        <input type="hidden" name="action" value="enregistrer_parrainage">
        <button type="submit">Enregistrer le Parrainage</button>
    </form>
</body>
</html>