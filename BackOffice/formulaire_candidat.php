<?php
$numero_carte_electeur = $_GET['numero_electeur'];
include 'db.php';
$sql = "SELECT * FROM electeurs WHERE numero_electeur = '$numero_carte_electeur'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $date_naissance = $row['date_naissance'];
} else {
    echo "Le numéro n'existe pas dans la table electeurs.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de candidature</title>
    <link rel="stylesheet" href="formulaire.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        

        <h1>Formulaire de candidature</h1>
        <form action="enregistrer.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="numero_electeur" value="<?php echo $numero_carte_electeur; ?>">

            <div class="form-group inline">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="form-group inline">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>

            <div class="form-group">
                <label for="parti_politique">Parti politique :</label>
                <input type="text" id="parti_politique" name="parti_politique">
            </div>

            <div class="form-group">
                <label for="slogan">Slogan :</label>
                <textarea id="slogan" name="slogan"></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Photo :</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="couleurs">Couleurs :</label>
                <input type="text" id="couleurs" name="couleurs" required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $date_naissance; ?>" required>
            </div>

            <div class="form-group">
                <label for="url_information">URL d'information :</label>
                <input type="url" id="url_information" name="url_information">
            </div>

            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>