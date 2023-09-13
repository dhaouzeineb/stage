<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administratif</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
 <div class="link-section">
        <a href="score.php" class="attention-link">VOIR LES SCORES DES ÉTUDIANTS</a>
    </div>

</head>
<body>
<header>
    <h1>Plateforme de Gestion des Mobilités d'Études</h1>
</header>
<a href="page1.php">Aller à la page d'accueil</a>

    <div class="container my-5">
        <h2>Liste des candidatures</h2>
        <a class="btn btn-primary" href="create.php" role="button">Nouvelle candidature</a><br>
        <table class="table">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Specialité</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "stage";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read data from database table
                $sql = "SELECT * FROM information";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['username']}</td>
                        <td>{$row['Nom']}</td>
                        <td>{$row['Prenom']}</td>
                        <td>{$row['classe']}</td>
                        <td>{$row['specialite']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='edit.php?username={$row['username']}'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='delete.php?username={$row['username']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<footer>
    <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
</footer>

</body>
</html>

