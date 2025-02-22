<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestparrainage");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer la liste des candidats
$sql = "SELECT nom, prenom, parti_politique, numero_electeur FROM candidats";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
    <link rel="stylesheet" href="listeC.css"> <!-- Lien vers le fichier CSS externe -->
</head>
<body>
    <div class="container">
        <h1>Liste des candidats</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Parti politique</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['nom'] . "</td>
                                <td>" . $row['prenom'] . "</td>
                                <td>" . $row['parti_politique'] . "</td>
                                <td class='action-buttons'>
                                    <a href='details.php?numero_electeur=" . $row['numero_electeur'] . "' class='details-button'>Détails</a>
                                    <form action='supprimer.php' method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce candidat ?\");'>
                                        <input type='hidden' name='numero_electeur' value='" . $row['numero_electeur'] . "'>
                                        <button type='submit' class='delete-button'>Supprimer</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun candidat enregistré.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Bouton Retour en bas de la page -->
        <div style="text-align: center; margin-top: 20px;">
            <button class="back-button" onclick="window.history.back();">Retour</button>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>