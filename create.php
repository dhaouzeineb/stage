<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administratif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
                    <th>Spécialité</th>
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

                // Handle form submission
                if (isset($_POST['submit'])) {
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $classe = $_POST['classe'];
                    $specialite = $_POST['specialite'];
                    $username = $_POST['username']; // Ajout de l'identifiant

                    // Insert data into the "information" table
                    $sql = "INSERT INTO `information`(`Nom`, `Prenom`, `classe`, `specialite`, `username`) VALUES ('$nom', '$prenom', '$classe', '$specialite', '$username')";
                    if ($connection->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $connection->error;
                    }
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

    <div class="col-lg-6 m-auto">
        <form method="post">
            <br><br>
            <div class="card">
                <div class="card-header bg-primary">
                    <h1 class="text-white text-center">Create New Member</h1>
                </div><br>

                <label> Nom : </label>
                <input type="text" name="nom" class="form-control"> <br>

                <label> Prénom : </label>
                <input type="text" name="prenom" class="form-control"> <br>

                <label> Classe : </label>
                <input type="text" name="classe" class="form-control"> <br>

                <label> Spécialité : </label>
                <input type="text" name="specialite" class="form-control"> <br>

                <label> Identifiant : </label>
                <input type="text" name="username" class="form-control"> <br>

                <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
                <a class="btn btn-info" type="submit" name="cancel" href="index.php"> Cancel </a><br>
            </div>
        </form>
    </div>
</body>
</html>

