<?php
include 'db.php'; // Fichier de connexion à la base de données

// Fonction pour enregistrer les tentatives d'upload dans la table historiqueupload
function logUploadAttempt($pdo, $status, $checksum) {
    $stmt = $pdo->prepare("INSERT INTO historiqueupload (status, checksum, upload_time, ip_address) VALUES (?, ?, NOW(), ?)");
    $stmt->execute([$status, $checksum, $_SERVER['REMOTE_ADDR']]);
}

// Vérifier si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checksum = $_POST['checksum'];
    $file = $_FILES['file'];

    // Vérifier si le fichier est bien un CSV
    if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'csv') {
        logUploadAttempt($pdo, 0, $checksum);
        die("Le fichier doit être au format CSV.");
    }

    // Vérifier l'empreinte SHA256
    $fileContent = file_get_contents($file['tmp_name']);
    $calculatedChecksum = hash('sha256', $fileContent);

    if ($calculatedChecksum !== $checksum) {
        logUploadAttempt($pdo, 0, $checksum);
        die("L'empreinte CHECKSUM ne correspond pas.");
    }

    // Vérifier si la table tempelecteurs existe avant d'insérer des données
    $tableExists = $pdo->query("SHOW TABLES LIKE 'tempelecteurs'")->rowCount();
    if ($tableExists == 0) {
        logUploadAttempt($pdo, 0, $checksum);
        die("Erreur : La table temporaire 'tempelecteurs' n'existe pas.");
    }

    // Charger le contenu du fichier dans la table temporaire
    $lines = explode(PHP_EOL, $fileContent);
    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if (count($data) >= 8) {
            $stmt = $pdo->prepare("INSERT INTO tempelecteurs (numero_electeur, nom, prenom, date_naissance, sexe, carte_identite, adresse_ip, upload_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
        }
    }

    // Vérification avec la fonction ControlerFichierElecteurs
    $checksumValid = $pdo->query("SELECT ControlerFichierElecteurs('{$calculatedChecksum}', '{$file['tmp_name']}')")->fetchColumn();
    if (!$checksumValid) {
        logUploadAttempt($pdo, 0, $checksum);
        die("L'empreinte ou l'encodage est incorrect.");
    }

    // Insérer les électeurs dans la table finale en évitant les doublons
    $stmt = $pdo->prepare("
        INSERT INTO electeurs (numero_electeur, nom, prenom, date_naissance, sexe, carte_identite, adresse_ip, upload_time)
        SELECT numero_electeur, nom, prenom, date_naissance, sexe, carte_identite, adresse_ip, upload_time 
        FROM tempelecteurs
        ON DUPLICATE KEY UPDATE 
            nom = VALUES(nom), 
            prenom = VALUES(prenom), 
            date_naissance = VALUES(date_naissance),
            sexe = VALUES(sexe),
            carte_identite = VALUES(carte_identite),
            adresse_ip = VALUES(adresse_ip),
            upload_time = VALUES(upload_time)
    ");
    $stmt->execute();

    // Nettoyer la table temporaire après l'importation
    $pdo->exec("DELETE FROM tempelecteurs");

    // Appeler la procédure stockée pour valider l'importation
    $pdo->exec("CALL ValiderImportation()");

    // Enregistrer l'upload réussi
    logUploadAttempt($pdo, 1, $checksum);

    // Afficher un message de confirmation
    echo "<script>document.getElementById('message').innerHTML = 'Fichier importé avec succès.';</script>";
}
?>

<!-- HTML pour afficher le message -->
<div id="message" style="color: green; font-weight: bold;">Fichier importé avec succés</div>
