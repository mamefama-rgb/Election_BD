<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM candidats ORDER BY nom ASC");
$candidats = $stmt->fetchAll();
?>
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
            width: 100%; /* Pour que le tableau prenne toute la largeur */
            border-collapse: collapse; /* Pour éviter le double bord */
        }
        th, td {
            padding: 15px; /* Espace dans les cellules */
            border: 1px solid #ddd; /* Bordure légère */
        }
        th {
            background-color: #f2f2f2; /* Couleur de fond des en-têtes */
            text-align: left; /* Alignement à gauche */
        }
    th {
        padding: 15px; /* Ajustez la valeur selon vos besoins */
        text-align: left; /* Alignement à gauche (optionnel) */
    }
    table {
    margin: 20px 0; /* Ajoute de l'espace au-dessus et en dessous du tableau */
}
</style>
<!-- HTML pour la saisie -->
 <br><br><br><br>
<div class="container">
<h2>Liste des Candidats Enregistrés</h2>
<table>
    <tr>
        <th>Numéro d'Électeur</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Parti</th>
        <th>Détails</th>
    </tr>
    <?php foreach ($candidats as $candidat): ?>
        <tr>
            <td><?php echo $candidat['numero_electeur']; ?></td>
            <td><?php echo $candidat['nom']; ?></td>
            <td><?php echo $candidat['prenom']; ?></td>
            <td><?php echo $candidat['parti_politique']; ?></td>
            <td>
                <a href="choix.php?">Parrainer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>