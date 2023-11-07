<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de connexion
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Valider les données (vous pouvez ajouter des validations supplémentaires ici)

    // Connexion à la base de données MySQL (WampServer en localhost)
    $serveur = 'localhost';
    $utilisateur = 'root';
    $motdepasse_db = ''; // Mot de passe de la base de données
    $basededonnees = 'tpl3info';

    $mysqli = new mysqli($serveur, $utilisateur, $motdepasse_db, $basededonnees);

    if ($mysqli->connect_error) {
        die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
    }

    // Requête SQL pour récupérer le mot de passe stocké
    $requete = $mysqli->prepare("SELECT motdepasse FROM utilisateurs WHERE email = ?");
    $requete->bind_param("s", $email);
    $requete->execute();
    $requete->bind_result($motdepasse_stocke);
    $requete->fetch();

    // Vérification du mot de passe
    if ($motdepasse_stocke && password_verify($motdepasse, $motdepasse_stocke)) {
        // Mot de passe correct, connectez l'utilisateur (par exemple, définissez une session)
        session_start();
        $_SESSION['email'] = $email;
        header("Location: index.html"); // Rediriger vers la page d'accueil après la connexion
    } else {
        // Mot de passe incorrect, afficher un message d'erreur
        header("Location: connexion.html?error=Mot de passe incorrect");
    }

    $requete->close();
    $mysqli->close();
}
?>
