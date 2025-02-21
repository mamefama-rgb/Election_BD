<?php
session_start(); // Démarrer la session
require 'db.php'; // Inclusion du fichier de connexion à la base de données

$message = '';

// Étape 1 : Traitement du formulaire d'identification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'identification') {
    $numero_electeur = $_POST['numero_electeur'];
    $numero_cin = $_POST['cin'];

    if (empty($numero_electeur) || empty($numero_cin)) {
        $message = "Veuillez remplir toutes les informations.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ? AND cin = ?");
        $stmt->execute([$numero_electeur, $numero_cin]);
        $electeur_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$electeur_info) {
            $message = "Informations d'identification incorrectes.";
        } else {
            $_SESSION['electeur_info'] = $electeur_info; // Stocker les informations de l'électeur
            header('Location: saisie_code.php'); // Redirection vers la page de code
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identification</title>
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
<div class="container">
    <h2>Identification</h2>

    <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="saisie_code.php" method="post">
        <label for="numero_electeur">Numéro de Carte d'Électeur :</label>
        <input type="text" name="numero_electeur" required>

        <label for="cin">Numéro de Carte d'Identité Nationale :</label>
        <input type="text" name="cin" required>

        <button type="submit">Valider</button>
    </form>
</body>
</html>