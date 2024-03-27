<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Covoit'UPHF</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body class="overflow">
	
	<!-- Header -->
	
	<header>
        <div class="logo-and-buttons">
			<div class="logo-container">
				<a href="recherche.php"><img src="image/CovoitUPHF2.png" alt="Logo"></a>
            </div>
			<div class="nav-buttons">
				<nav>
					<ul>
						<li><button onclick="window.location.href='recherche.php'" class="button1">Rechercher un trajet</a></li>
						<li><button onclick="window.location.href='propose.php'" class="button1">Proposer un trajet</a></li>
						<li><button onclick="window.location.href='contact.php'" class="button1">Nous contacter</button></li>
					</ul>
				</nav>
			</div>
		</div>
    </header>
	
    <br><br><br>
        
	<!-- Formulaire pour se connecter -->
	
	<div class="form-container">
	<form id="login-form" method="POST">
		<h1>Connexion</h1><br><br>
		
		<div class="input-group">
			<label for="email">Adresse e-mail :</label>
			<input type="email" id="email" name="email" required><br><br>
		</div>
		
		<div class="input-group">
			<label for="motdepasse">Mot de passe :</label>
			<input type="password" id="motdepasse" name="motdepasse" required><br><br>
		</div>
		
        <div class="input-group">
			<input type="submit" value="Se connecter">
		</div>
    </form>
	</div>
    
	<br><br><div class="br"></div>
	
    <!-- Footer -->
	
	<footer>
		
		<div class="logo-container">
			<a href="recherche.php"><img src="image/CovoitUPHF2.png" alt="Logo"></a>
		</div>
		
		<div id="texte-footer">&copy; <span id="currentYear"></span> Covoit'UPHF. Tous droits réservés.</div>
		<div id="texte-footer">Le covoiturage est une manière responsable et écologique de se déplacer. Nous nous engageons à faciliter la connexion entre conducteurs et passagers pour encourager une mobilité durable.</div>
		<div id="texte-footer">Les informations fournies sur ce site sont données à titre indicatif. Veuillez consulter les <a href="conditions_utilisation.html">conditions d'utilisation</a> et la <a href="politique_confidentialite.html">politique de confidentialité</a> pour plus de détails.</div>
		
	</footer>
	
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de connexion
    $email = $_POST['email'];
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

    // Requête SQL pour récupérer le mot de passe haché et l'ID de l'utilisateur
    $requete = $mysqli->prepare("SELECT id, motdepasse FROM utilisateur WHERE email = ?");
    $requete->bind_param("s", $email);
    $requete->execute();
    $requete->bind_result($id_utilisateur, $motdepasse_stocke);
    $requete->fetch();

    // Vérification du mot de passe haché
    if (password_verify($motdepasse, $motdepasse_stocke)) {
        // Mot de passe correct, connectez l'utilisateur
        session_start();
        $_SESSION['id'] = $id_utilisateur; // Stocker l'ID de l'utilisateur dans la session
        header("Location: recherche.php"); // Rediriger vers la page d'accueil après la connexion
    } else {
        // Mot de passe incorrect, afficher un message d'erreur
        header("Location: connexion.php?error=Informations d'identification incorrectes");
    }

    $requete->close();
    $mysqli->close();
}
?>
