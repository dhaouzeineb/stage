<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=stage;charset=utf8;', 'root', ''); // Ajoutez le mot de passe si nécessaire

if (isset($_POST['identifiant'])) {
    $identifiant = $_POST['identifiant'];

    // Vérifier si l'identifiant existe déjà dans la table "info"
    $checkInfoQuery = $bdd->prepare('SELECT * FROM info WHERE identifiant = ?');
    $checkInfoQuery->execute(array($identifiant));

    $infoData = $checkInfoQuery->fetch();

    if ($infoData) {
        echo '<div class="message-section"><p class="error-message">L\'Cet étudiant a déjà postuler sa condidature .</p></div>';
    } else {
        // Vérifier si l'identifiant existe dans la table "utilisateurs"
        $checkUserQuery = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
        $checkUserQuery->execute(array($identifiant));

        $userData = $checkUserQuery->fetch();

        if ($userData) {
            // L'identifiant existe dans la table "utilisateurs", vous pouvez insérer les données dans la table "info"
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $moyenne_bac = $_POST['moyenne_bac'];
            $moyenne_annee_precedente = $_POST['moyenne_annee_precedente'];
            $moyenne_annee_cours = $_POST['moyenne_annee_cours'];
            $specialite = $_POST['specialite'];
            $classe = $_POST['classe'];
            $annee_bac = $_POST['annee_bac'];

            $insertInfoQuery = $bdd->prepare('INSERT INTO info (identifiant, nom, prenom, moyenne_bac, moyenne_annee_precedente, moyenne_annee_cours, specialite, classe, annee_bac) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            if ($insertInfoQuery->execute(array($identifiant, $nom, $prenom, $moyenne_bac, $moyenne_annee_precedente, $moyenne_annee_cours, $specialite, $classe, $annee_bac))) {
                echo '<div class="message-section"><p class="success-message">Les données ont été insérées avec succès dans la base de données.</p></div>';
            } else {
                echo '<div class="message-section"><p class="error-message">Erreur lors de l\'insertion des données : ' . $insertInfoQuery->errorInfo()[2] . '</p></div>';
            }
        } else {
            echo '<div class="message-section"><p class="error-message">L\'identifiant n\'existe pas dans la base de données .Cet étudiant n\'est pas inscrit dans l\'école.</p></div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="boutton.css">
</head>
<body>
<header>
    <h1>Plateforme de Gestion des Mobilités d'Études</h1>
</header>
<p class="paragraph" id="monParagraphe">
    <br><a href="page1.php">Aller à la page d'accueil</a></br>
</p>

<?php
if (isset($_SESSION['username'])) {
    echo "<h3>BIENVENUE!</h3> utilisateur : " . $_SESSION['username'] . "<br>";
}
?>
<p class="paragraph" id="monParagraphe">
    <h4> Veuillez remplir correctement ces champs pour s'inscrire !</h4>
</p>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="identifiant">Identifiant :</label>
    <input type="text" name="identifiant" id="identifiant" required><br><br>

    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br><br>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" required><br><br>

    <label for="moyenne_bac">Moyenne du Bac :</label>
    <input type="number" name="moyenne_bac" id="moyenne_bac" step="0.01" required><br><br>

    <label for="moyenne_annee_precedente">Moyenne de l'année précédente :</label>
    <input type="number" name="moyenne_annee_precedente" id="moyenne_annee_precedente" step="0.01" required><br><br>

    <label for="moyenne_annee_cours">Moyenne de l'année en cours :</label>
    <input type="number" name="moyenne_annee_cours" id="moyenne_annee_cours" step="0.01" required><br><br>

    <label for="specialite">Spécialité :</label>
    <select name="specialite" id="specialite" required>
        <option value="NIDS">NIDS</option>
        <option value="SE">SE</option>
        <option value="SAE">SAE</option>
        <option value="INFINI">INFINI</option>
        <option value="SLEAM">SLEAM</option>
        <option value="SIM">SIM</option>
        <option value="TWIN">TWWIN</option>
        <option value="ERP/BI">ERP/BI</option>
        <option value="DS">DS</option>
        <!-- Ajoutez d'autres options au besoin -->
    </select><br><br>

    <label for="classe">Classe :</label>
    <input type="text" name="classe" id="classe" required><br><br>

    <label for="annee_bac">Année du Bac :</label>
    <input type="text" name="annee_bac" id="annee_bac" required><br><br>

    <!-- Ajoutez ici les autres champs du formulaire -->
    <!-- Exemple : -->
    <!--
    <label for="autre_champ">Autre Champ :</label>
    <input type="text" name="autre_champ" id="autre_champ" required><br><br>
    -->

    <input type="submit" name="submit" value="Postuler condidature">
</form>

<footer>
    <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
</footer>
</body>
</html>

