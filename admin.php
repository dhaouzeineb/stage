<?php 
 //Nous allons démarrer la session avant toute chose
   session_start() ;
  if(isset($_POST['boutton-valider'])){ // Si on clique sur le boutton , alors :
    //Nous allons verifiér les informations du formulaire
    if(isset($_POST['username']) && isset($_POST['password'])) { //On verifie ici si l'utilisateur a rentré des informations
      //Nous allons mettres l'email et le mot de passe dans des variables
      $username = $_POST['username'] ;
      $password = $_POST['password'] ;
      $erreur = "" ;
       //Nous allons verifier si les informations entrée sont correctes
       //Connexion a la base de données
       $nom_serveur = "localhost";
       $utilisateur = "root";
       $mot_de_passe ="";
       $nom_base_données ="stage" ;
       $con = mysqli_connect($nom_serveur , $utilisateur ,$mot_de_passe , $nom_base_données);
       //requete pour selectionner  l'utilisateur qui a pour email et mot de passe les identifiants qui ont été entrées
        $req = mysqli_query($con , "SELECT * FROM admin WHERE username = '$username' AND password ='$password' ") ;
        $num_ligne = mysqli_num_rows($req) ;//Compter le nombre de ligne ayant rapport a la requette SQL
        if($num_ligne > 0){
            header("Location:tableau.php") ;//Si le nombre de ligne est > 0 , on sera redirigé vers la page bienvenu
            // Nous allons créer une variable de type session qui vas contenir l'email de l'utilisateur
            $_SESSION['username'] = $username ;
        }else {//si non
            $erreur = "login ou Mots de passe incorrectes !";
        }
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
<a href="page1.php">Aller à la page d'acceuil</a>

 <nav>
        <!-- ... Menu de navigation ... -->
</nav>
<main>
   <section>
<br>
       <h1> Espace Administration & Gouvernance</h1>
</br>
       <?php 
       if(isset($erreur)){// si la variable $erreur existe , on affiche le contenu ;
           echo "<p class= 'Erreur'>".$erreur."</p>"  ;
       }
       ?>
       <form action="" method="POST">  <!--on ne mets plus rien au niveau de l'action , pour pouvoir envoyé les données  dans la même page -->
	  <br>
	   <label>Login</label>
           <input type="text" name="username">
           <label >Mot de passe</label>
           <input type="password" name="password">
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
