<?php
// Démarrer la session
session_start();

if(isset($_POST['boutton-valider'])) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $erreur = "";

        // Connexion à la base de données
        $nom_serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "";
        $nom_base_donnees = "stage";
        
        $con = mysqli_connect($nom_serveur, $utilisateur, $mot_de_passe, $nom_base_donnees);

        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = mysqli_prepare($con, "SELECT * FROM utilisateurs WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $num_ligne = mysqli_stmt_num_rows($stmt);

        if($num_ligne > 0) {
            $_SESSION['username'] = $username;
            header("Location: formulairenew.php");
        } else {
            $erreur = "Login ou mot de passe incorrect !";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Plateforme de Gestion des Mobilités d'Études</h1>
</header>
<a href="page1.php">Aller à la page d'accueil</a>

<nav>
    <!-- ... Menu de navigation ... -->
</nav>
<main>
    <section>
<br>
	<h1>Espace Étudiant </h1>
</br>
        <?php
        if(isset($erreur)) {
            echo "<p class='Erreur'>" . $erreur . "</p>";
        }
        ?>
	<form method="POST">
<br>
            <label for="username">Login</label>
            <input type="text" name="username" id="username">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
	    <input type="submit" value="Se connecter" name="boutton-valider">
</br>
        </form>
    </section>
</main>
<footer>
    <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
</footer>
</body>
</html>

