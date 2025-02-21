<?php
// Connexion à la base de données
include 'db.php';
require '../vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Traitement du choix du candidat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidat_id = $_POST['id_candidat'];
    $code_confirmation = rand(10000, 99999);

    // Enregistrement du parrainage
    // Remplacez `id_electeur` par l'ID de l'électeur authentifié
    $stmt = $pdo->prepare("INSERT INTO parrainages (numero_electeur, id_candidat) VALUES (?, ?)");
    $stmt->execute([$id_electeur, $candidat_id]);

    // Envoi du code de confirmation
    // Code d'authentification envoyé par SMS et Email
    sendConfirmation($telephone, $email, $code_confirmation);

    echo '<div class="container">';
    echo '<h2>Confirmation de votre Choix</h2>';
    echo '<p>Un code de confirmation a été envoyé à votre téléphone et votre email.</p>';
    echo '<form action="valider_choix.php" method="post">';
    echo '<label for="code_confirmation">Saisir le Code de Confirmation :</label>';
    echo '<input type="text" name="code" required>';
    echo '<button type="submit">Valider</button>';
    echo '</form>';
    echo '</div>';
}
function sendConfirmation($telephone, $email, $code_confirmation) {
    // Envoi du code de confirmation par SMS
   /* $twilio_sid = 'YOUR_TWILIO_SID';
    $twilio_token = 'YOUR_TWILIO_TOKEN';
    $twilio_number = 'YOUR_TWILIO_PHONE_NUMBER';

    $client = new Client($twilio_sid, $twilio_token);
    $client->messages->create(
        $telephone,
        array(
            'from' => $twilio_number,
            'body' => "Votre code de confirmation est : $code_confirmation"
        )
    );*/

    // Envoi du code de confirmation par Email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mamefamafall16@gmail.com';
        $mail->Password = 'Famafall1';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email, 'Nom de l\'Expéditeur');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Code de Confirmation';
        $mail->Body    = "Votre code de confirmation est : <strong>$code_confirmation</strong>";

        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}
?>