<?php
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['username'])) {
        header("Location: tableau.php");
        exit;
    }

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "stage";

    // Créer une connexion
    $connection = new mysqli($servername, $dbUsername, $dbPassword, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $username = $_GET['username'];
    $sql = "SELECT * FROM information WHERE username=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $Nom = "";
    $Prenom = "";
    $specialite = "";
    $classe = "";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Nom = $row["Nom"];
        $Prenom = $row["Prenom"];
        $specialite = $row["specialite"];
        $classe = $row["classe"];
    } else {
        header("Location: tableau.php");
        exit;
    }

    $stmt->close();
    $connection->close();
} else {
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "stage";

    // Créer une connexion
    $connection = new mysqli($servername, $dbUsername, $dbPassword, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $username = $_POST["username"];
    $Nom = $_POST["Nom"];
    $Prenom = $_POST["Prenom"];
    $specialite = $_POST["specialite"];
    $classe = $_POST["classe"];

    $sql = "UPDATE information SET Nom=?, Prenom=?, specialite=?, classe=? WHERE username=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $Nom, $Prenom, $specialite, $classe, $username);

    if ($stmt->execute()) {
        $success = "Enregistrement mis à jour avec succès";
    } else {
        $error = "Erreur lors de la mise à jour de l'enregistrement : " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <h1>Plateforme de Gestion des Mobilités d'Études</h1>
</header>
<a href="tableau.php">Retour</a>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" class="fw-bold">
  <!-- ... le reste de votre code HTML reste inchangé ... -->
</nav>
<div class="col-lg-6 m-auto">
  <form method="post">
    <br><br>
    <div class="card">
      <div class="card-header bg-warning">
        <h1 class="text-white text-center">Mettre à Jour le Membre</h1>
      </div><br>
      <input type="hidden" name="username" value="<?php echo $username; ?>" class="form-control"> <br>
      <label>Nom :</label>
      <input type="text" name="Nom" value="<?php echo $Nom; ?>" class="form-control"> <br>
      <label>Prénom :</label>
      <input type="text" name="Prenom" value="<?php echo $Prenom; ?>" class="form-control"> <br>
      <label>Spécialité :</label>
      <input type="text" name="specialite" value="<?php echo $specialite; ?>" class="form-control"> <br>
      <label>Classe :</label>
      <input type="text" name="classe" value="<?php echo $classe; ?>" class="form-control"> <br>
      <button class="btn btn-success" type="submit" name="submit">Enregistrer</button><br>
      <a class="btn btn-info" href="tableau.php">Annuler</a><br>
    </div>
    <?php
      if (isset($error) && $error !== "") {
        echo '<div class="alert alert-danger mt-3">' . $error . '</div>';
      } elseif (isset($success) && $success !== "") {
        echo '<div class="alert alert-success mt-3">' . $success . '</div>';
      }
    ?>
  </form>
</div>
<footer>
    <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
</footer>
</body>
</html>

