<?php
session_start(); // Démarrer la session

include 'db.php';
// Vérification des informations d'authentification
$verification_success = false;
$electeur = null;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Traitement du formulaire de vérification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verifier') {
    $numero_electeur = $_POST['numero_electeur'];
    $numero_cin = $_POST['cin'];

    // Requête pour vérifier si les informations existent
    $stmt = $pdo->prepare("SELECT * FROM electeurs WHERE numero_electeur = ? AND cin = ?");
    $stmt->execute([$numero_electeur, $numero_cin]);
    $electeur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($electeur) {
        $verification_success = true;

        // Génération et stockage du code d'authentification
        $code_auth = rand(100000, 999999);
        $_SESSION['code'] = $code_auth;

        // Envoi du code d'authentification à l'utilisateur
        sendNotification($electeur['telephone'], $electeur['email'], $code_auth);
    }
}

// Vérification du code d'authentification saisi par l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'valider') {
    $code_auth = $_POST['code'];

    if (isset($_SESSION['code']) && $code_auth == $_SESSION['code']) {
        // Si le code est correct, redirigez vers l'espace électeur
        header("Location: espace_electeur.php?numero_electeur=" . urlencode($electeur['numero_electeur']));
        exit();
    } else {
        $error_message = "Le code d'authentification est incorrect.";
    }
}

function sendNotification($telephone, $email, $code_auth) {
    
    // Envoi du code d'authentification par SMS et email
    /*require '../vendor/autoload.php';
    use Twilio\Rest\Client;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $twilio_sid = 'YOUR_TWILIO_SID';
    $twilio_token = 'YOUR_TWILIO_TOKEN';
    $twilio_number = 'YOUR_TWILIO_PHONE_NUMBER';

    $client = new Client($twilio_sid, $twilio_token);
    $client->messages->create(
        $telephone,
        array(
            'from' => $twilio_number,
            'body' => "Votre code d'authentification est : $code_auth"
        )
    );*/

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'votre_email@example.com';
        $mail->Password = 'votre_mot_de_passe';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('votre_email@example.com', 'Nom de l\'Expéditeur');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Code d\'Authentification';
        $mail->Body    = "Votre code d'authentification est : <strong>$code_auth</strong>";

        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parrainage</title>
    <link rel="stylesheet" href="Styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<header>
    <div class="contain">
 
        <input type="checkbox" id="manu" hidden>
        <nav>
            <a href="accueil.html">Accueil</a>
            <a href="liste_candidats.php">Candidats</a>
            <a href="ouverture_parrainage.php">Date</a>
        </nav>
        </div>
</header>
    <div class="container">
        <div class="from-box login">
        <?php if (!$verification_success): ?>
            <form action="liste_candidats.php" method="post">
            <h1>Saisir vos Informations</h1>
                <input type="hidden" name="action" value="verifier">
                
                <div class="input-box">
                <label for="numero_electeur">Numéro de Carte d'Électeur :</label>
                <input type="text" name="numero_electeur" required>
                <i class="bx bxs-user"></i>
                </div>
                 <div class="input-box">
                <label for="numero_cin">Numéro de Carte d'Identité Nationale :</label>
                <input type="text" name="cin" required>
                <i class="bx bxs-user"></i>
                 </div>
                 <div type="submit" class="btn" href="liste_candidats.php">Verifier</div>
                 <br><br>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google' ></i></a>
                    <a href="#"><i class='bx bxl-facebook' ></i></a>
                    <a href="#"><i class='bx bxl-github' ></i></a>
                    <a href="#"><i class='bx bxl-linkedin' ></i></a>
                </div>
            </form>
        </div>
    
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Bonjour, Bienvenue!</h1>
                <p>Vous n'avez pas de compte ?</p>
                <button class="btn register-btn">S'inscrire</button>
            </div>
        </div>
    </div>
    <script src="script.js">
    const container = document.querySelector('.container');
        const registerBtn = document.querySelector('.register-btn');
        const loginBtn = document.querySelector('.login-btn');
        const passwordInput = document.querySelector('input[type="password"]');
        const passwordStrengthIndicator = document.getElementById('passwordStrength');
        
        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
        });
        
        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
        });
        
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            let strength = 'Faible';
        
            if (password.length > 8) {
                strength = 'Moyenne';
            }
            if (/[A-Z]/.test(password) && /[0-9]/.test(password) && password.length > 10) {
                strength = 'Forte';
            }
        
            passwordStrengthIndicator.textContent = `Force du mot de passe: ${strength}`;
        });
        
        
        
        </script>
</body>
</html>
            
            <?php elseif ($electeur): ?>
            <h2>Informations de l'Électeur</h2>
            <p>Nom : <?php echo $electeur['nom']; ?></p>
            <p>Prénom : <?php echo $electeur['prenom']; ?></p>
            <p>Date de Naissance : <?php echo $electeur['date_naissance']; ?></p>
            <p>Bureau de Vote : <?php echo $electeur['bureau_vote']; ?></p>

            <form action="" method="post">
                <input type="hidden" name="action" value="valider">
                <label for="code">Saisir votre Code d'Authentification :</label>
                <input type="text" name="code" required>
                <button type="submit">Valider</button>
            </form>
            <?php if (isset($error_message)): ?>
                <p style="color:red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
