<?php
include 'db.php';

// Vérification des informations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_electeur = $_POST['numero_electeur'];
    $numero_cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $bureau_vote = $_POST['bureau_vote'];

    // Requête pour vérifier si les informations existent
    $stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ? AND cin = ? AND nom = ? AND bureau_vote = ?");
    $stmt->execute([$numero_electeur, $numero_cin, $nom, $bureau_vote]);
    $electeur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($electeur) {
        // Si les informations sont valides, afficher un nouveau formulaire pour le téléphone et l'email
   echo'<input type="hidden" name="prenom" value="'.htmlspecialchars($electeur['prenom']).'">';
        echo'<input type="hidden" name="nom" value="'.htmlspecialchars($electeur['nom']).'">';
        echo'<input type="hidden" name="bureau_vote" value="'.htmlspecialchars($electeur['bureau_vote']).'">';
        echo'<input type="hidden" name="cin" value="'.htmlspecialchars($electeur['cin']).'">';
        echo'<input type="hidden" name="numero_electeur" value="'.htmlspecialchars($electeur['numero_electeur']).'">';

        echo '<div class="container">';
        echo '<h2>Informations Valides</h2>';
        echo '<form action="generer_code.php" method="post">';
        echo '<input type="hidden" name="numero_electeur" value="' . $electeur['numero_electeur'] . '">';
        echo '<label for="telephone">Numéro de Téléphone :</label>';
        echo '<input type="text" name="telephone" required>';

        echo '<label for="email">Adresse Email :</label>';
        echo '<input type="email" name="email" required>';

        echo '<button type="submit">Soumettre</button>';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<div class="container">';
        echo '<h2>Erreur</h2>';
        echo '<p>Les informations saisies ne correspondent pas à nos enregistrements.</p>';
        echo '</div>';
    }
}
?>