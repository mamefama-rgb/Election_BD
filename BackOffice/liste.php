<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats validés</title>
    <style>
        /* Style global */
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f7ff; /* Fond bleu clair */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            text-align: center;
        }

        /* Titre de la page */
        h1 {
            color: #004080; /* Bleu foncé pour le titre */
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: bold;
        }

        /* Styles CSS pour la table */
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white; /* Fond blanc pour la table */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color:#4da6ff; /* Bleu foncé pour les en-têtes */
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Bouton Retour */
        .back-button {
            background-color: #ff4d4d; /* Rouge pour le bouton */
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color:rgb(0, 126, 204); /* Rouge plus foncé au survol */
        }
    </style>
</head>
<body>
    <h1>Liste des candidats validés</h1>

    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestparrainage";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer la liste des candidats
    $sql = "SELECT * FROM candidats";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Parti politique</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['nom'] . "</td>
                    <td>" . $row['prenom'] . "</td>
                    <td>" . $row['parti_politique'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun candidat enregistré.</p>";
    }

    $conn->close();
    ?>

    <!-- Bouton Retour -->
    <button class="back-button" onclick="window.location.href='index.html'">Retour</button>
</body>
</html>