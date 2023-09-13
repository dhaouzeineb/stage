<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calcul du Score des Étudiants</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylescore.css">
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
            <h1>Calcul du Score des Étudiants</h1>

            <?php
            // Connexion à la base de données (à adapter selon vos informations)
            $serveur = "localhost";
            $utilisateur = "root";
            $mot_de_passe = "";
            $base_de_donnees = "stage"; // Nom de la base de données "stage"

            $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Échec de la connexion à la base de données : " . $connexion->connect_error);
            }

            // Sélectionner les données de la table "info" triées par score en ordre décroissant
            $requete = "SELECT identifiant, moyenne_bac, moyenne_annee_precedente, moyenne_annee_cours 
                        FROM info 
                        ORDER BY ((moyenne_bac + moyenne_annee_precedente + moyenne_annee_cours) * 100) DESC"; // Utilisez "DESC" pour un tri décroissant

            $resultat = $connexion->query($requete);

            // Vérifier si des résultats ont été trouvés
            if ($resultat->num_rows > 0) {
                // Créer la table pour afficher les résultats
                echo "<table border='1'>";
                echo "<tr><th>Identifiant</th><th>Score</th></tr>";

                // Parcourir les résultats et calculer le score pour chaque étudiant
                while ($row = $resultat->fetch_assoc()) {
                    $identifiant = $row["identifiant"];
                    $moyenne_bac = $row["moyenne_bac"];
                    $moyenne_annee_precedente = $row["moyenne_annee_precedente"];
                    $moyenne_annee_actuelle = $row["moyenne_annee_cours"];

                    // Calculer le score
                    $score = ($moyenne_bac + $moyenne_annee_precedente + $moyenne_annee_cours) * 100;

                    // Vérifier si l'identifiant existe déjà dans la table "score"
                    $verification_existance = "SELECT COUNT(*) AS count FROM score WHERE identifiant = '$identifiant'";
                    $resultat_verification = $connexion->query($verification_existance);
                    $row_verification = $resultat_verification->fetch_assoc();
                    $count = $row_verification["count"];

                    // Si l'identifiant n'existe pas dans la table "score", l'insérer
                    if ($count == 0) {
                        // Insérer le score dans la table "score"
                        $insertion_score = "INSERT INTO score (identifiant, score) VALUES ('$identifiant', '$score')";
                        $connexion->query($insertion_score);
                    }

                    // Afficher les données dans le tableau
                    echo "<tr><td>$identifiant</td><td>$score</td></tr>";
                }

                echo "</table>";
            } else {
                echo "Aucun résultat trouvé.";
            }

            // Fermer la connexion à la base de données
            $connexion->close();
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Plateforme de Mobilités d'Études</p>
    </footer>
</body>
</html>

