<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>
   <!-- Header -->
	
	<header>
    <div class="logo-and-buttons">
		<div class="logo-container">
			<a href="recherche.php"><img src="image/CovoitUPHF2.png" alt="Logo"></a>
		</div>
		<div class="nav-buttons">
        <nav>
            <ul>
                <li><button onclick="window.location.href='recherche.php'" class="button1">Rechercher un trajet</button></li>
                <li><button onclick="window.location.href='propose.php'" class="button1">Proposer un trajet</button></li>
				<li><button onclick="window.location.href='contact.php'" class="button1">Nous contacter</button></li>
			</ul>
        </nav>
		</div>
	</div>
    </header>
    
	<br><br>
    
	<!-- Formulaire pour l'inscription -->
	
	<div class="form-container">
	<form id="registration-form" method="POST">
        <h1>Inscription</h1><br><br>
		
		<div class="input-group">
			<label for="prenom">Prénom :</label>
			<input type="text" id="prenom" name="prenom" required><br><br>
		</div>
		
		<div class="input-group">
			<label for="nom">Nom :</label>
			<input type="text" id="nom" name="nom" required><br><br>
		</div>
        
		<div class="input-group">
			<label for="email">Adresse e-mail :</label>
			<input type="text" id="email" name="email" required><br><br>
        </div>
		
		<div class="input-group">
			<label for="date_naissance">Date de naissance</label>
			<input type="date" id="date_naissance" name="date_naissance" required><br><br>
        </div>
		
		<div class="input-group">
			<label for="motdepasse">Mot de passe :</label>
			<input type="password" id="motdepasse" name="motdepasse" required><br><br>
        </div>
		
		<div class="input-group">
			<input type="submit" value="S'incrire">
		</div>
	</form>
    </div>
    
   <!-- Footer -->
	
	<footer>
		
		<div class="logo-container">
			<a href="recherche.php"><img src="image/CovoitUPHF2.png" alt="Logo"></a>
		</div>
		
		<div id="texte-footer">&copy; <span id="currentYear"></span> Covoit'UPHF. Tous droits réservés.</div>
		<div id="texte-footer">Le covoiturage est une manière responsable et écologique de se déplacer. Nous nous engageons à faciliter la connexion entre conducteurs et passagers pour encourager une mobilité durable.</div>
		<div id="texte-footer">Les informations fournies sur ce site sont données à titre indicatif. Veuillez consulter les <a href="conditions_utilisation.html">conditions d'utilisation</a> et la <a href="politique_confidentialite.html">politique de confidentialité</a> pour plus de détails.</div>
		
	</footer>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire d'inscription
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $date_naissance = $_POST['date_naissance'];
        $motdepasse = $_POST['motdepasse'];

        // Connexion à la base de données MySQL (WampServer en localhost)
        $serveur = 'localhost';
        $utilisateur = 'root';
        $motdepasse_db = ''; // Mot de passe de la base de données
        $basededonnees = 'tpl3info';

        $mysqli = new mysqli($serveur, $utilisateur, $motdepasse_db, $basededonnees);

        if ($mysqli->connect_error) {
            die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
        }

        // Hacher le mot de passe
        $motdepasse_hache = password_hash($motdepasse, PASSWORD_DEFAULT);

        // Requête SQL pour insérer les données dans la base de données
        $requete = $mysqli->prepare("INSERT INTO utilisateur (nom, prenom, email, date_naissance, motdepasse) VALUES (?, ?, ?, ?, ?)");
        if (!$requete) {
            die('Erreur de préparation de la requête : ' . $mysqli->error);
        }

        $requete->bind_param("sssss", $nom, $prenom, $email, $date_naissance ,$motdepasse_hache);

        if ($requete->execute()) {
            // L'inscription a réussi, récupérer l'ID de l'utilisateur nouvellement inscrit
            $nouvelUtilisateurId = $mysqli->insert_id;

            // Démarrez la session
            session_start();

            // Stockez l'ID de l'utilisateur dans la session
            $_SESSION['id'] = $nouvelUtilisateurId;

            // Rediriger l'utilisateur vers une page de confirmation
            header("Location: recherche.php");
            exit;
        } else {
            // Afficher un message d'erreur en cas d'échec de l'inscription
            header("Location: inscription.php?error=Erreur lors de l'inscription");
            exit;
        }

        $requete->close();
        $mysqli->close();
    }
    ?>
</body>
</html>
