<?php
// Connexion à la base de données
include 'db.php';

// Récupérer les données du formulaire
$numero_carte_electeur = $_POST['numero_electeur'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$parti_politique = $_POST['parti_politique'];
$slogan = $_POST['slogan'];
$couleurs = $_POST['couleurs'] ;
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date_naissance = $_POST['date_naissance'];
$url_information = $_POST['url_information'];

// Gérer l'upload de la photo
$photo = "uploads/" . basename($_FILES["photo"]["name"]);
move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);

// Enregistrer les informations dans la table candidats
$sql = "INSERT INTO candidats (numero_electeur, email, telephone, parti_politique, slogan, photo, couleurs, nom, prenom, date_naissance , url_information)
        VALUES ('$numero_carte_electeur', '$email', '$telephone', '$parti_politique', '$slogan', '$photo', '$couleurs' , '$nom', '$prenom', '$date_naissance', '$url_information')";

if ($conn->query($sql) === TRUE) {
    // Rediriger vers la liste des candidats
    header("Location: listeC.php");
    exit();
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>