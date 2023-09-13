<?php
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "stage";

    // Créer une connexion
    $connection = new mysqli($servername, $dbUsername, $dbPassword, $database);

    // Vérifier la connexion
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Utilisation de requête préparée pour éviter les injections SQL
    $sql = "DELETE FROM `information` WHERE username=?";
    $stmt = $connection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $stmt->close();
            $connection->close();
            header('Location: tableau.php');
            exit;
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $connection->error;
    }
}
?>

