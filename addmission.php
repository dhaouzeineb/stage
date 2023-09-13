<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter votre résultat !</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Plateforme de Gestion des Mobilités d'Études</h1>
    </header>
    <a href="page1.php">Aller à la page d'acceuil</a>
    <nav>
        <!-- ... Menu de navigation ... -->
    </nav>
    <main>
        <section>
            <br>
            <h1>Consulter votre résultat!</h1>
            </br>
            <form method="post">
                <label>Identifiant : </label>
                <input type="text" name="identifiant" required>
                <button type="submit" name="consulter">Consulter Résultat</button>
            </form>
        </section>

        <?php
        // Vérifier si le bouton "Consulter Résultat" a été cliqué
        if (isset($_POST['consulter'])) {
            // Récupérer l'identifiant saisi dans le formulaire
            $identifiant = $_POST['identifiant'];

            // Effectuer une requête SQL pour vérifier si l'identifiant existe dans la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "stage";

            // Créer une connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $database);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Erreur de connexion : " . $conn->connect_error);
            }

            // Échapper les données pour éviter les injections SQL
            $identifiant = $conn->real_escape_string($identifiant);

            // Exécuter la requête SQL pour vérifier l'identifiant
            $query = "SELECT * FROM score WHERE identifiant ='$identifiant'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // L'identifiant existe dans la base de données, afficher un message de bienvenue
                echo "<p>Bienvenue, $identifiant !</p>";

                // Récupérer le score de l'étudiant
                $scoreQuery = "SELECT score FROM score WHERE identifiant ='$identifiant'";
                $scoreResult = $conn->query($scoreQuery);
                $row = $scoreResult->fetch_assoc();
                $score = $row["score"];

                // Récupérer les trois premiers scores
                $top3Query = "SELECT score FROM score ORDER BY score DESC LIMIT 3";
                $top3Result = $conn->query($top3Query);

                $top3Scores = [];
                while ($row = $top3Result->fetch_assoc()) {
                    $top3Scores[] = $row["score"];
                }

                // Vérifier si le score de l'étudiant est dans le top 3
                if (in_array($score, $top3Scores)) {
                    echo "<p>Vous êtes admis !</p>";
                } else {
                    echo "<p>Désolé, vous n'êtes pas admis.</p>";
                }
            } else {
                // L'identifiant n'existe pas dans la base de données, afficher un message "Candidat non inscrit"
                echo "<p>Candidat non inscrit</p>";
            }

            // Fermer la connexion à la base de données
            $conn->close();
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
    </footer>
</body>
</html>

