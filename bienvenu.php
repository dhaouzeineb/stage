<?php 
//On demare la session sur sur cette page 
session_start() ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
     //Ensuite on affiche le contenu de la variable session
     echo "<p class ='message'> Bonjour " .  $_SESSION['username'] . "</p>";
     $username = $_SESSION['username'];
$req = mysqli_query($con, "SELECT * FROM information WHERE username = '$username'");
$utilisateur = mysqli_fetch_assoc($req);

    ?>
 <section>
        <h1>Bienvenue, <?php echo $utilisateur['prenom'] . ' ' . $utilisateur['nom']; ?></h1>
        <p>Username: <?php echo $utilisateur['username']; ?></p>
        <p>Classe: <?php echo $utilisateur['classe']; ?></p>
        <p>Option: <?php echo $utilisateur['option']; ?></p>
        <!-- Ajoutez ici les autres colonnes de la table "information" que vous souhaitez afficher -->
        <a href="deconnexion.php">Se déconnecter</a>
    </section>

</body>
</html>
