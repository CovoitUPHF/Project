<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire d'inscription
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Valider les données (vous pouvez ajouter des validations supplémentaires ici)

    // Connexion à la base de données MySQL (WampServer en localhost)
    $serveur = 'localhost';
    $utilisateur = 'root';
    $motdepasse = '';
    $basededonnees = 'tpl3info';

    $mysqli = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    if ($mysqli->connect_error) {
        die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
    }

    // Hacher le mot de passe
    $motdepasse_hache = password_hash($motdepasse, PASSWORD_DEFAULT);

    // Requête SQL pour insérer les données dans la base de données
    $requete = $mysqli->prepare("INSERT INTO utilisateurs (prenom, nom, email, motdepasse) VALUES (?, ?, ?, ?)");
    $requete->bind_param("ssss", $prenom, $nom, $email, $motdepasse_hache);

    if ($requete->execute()) {
        // L'inscription a réussi, rediriger l'utilisateur vers une page de confirmation
        header("Location: index.html");
        exit;
    } else {
        // Afficher un message d'erreur en cas d'échec de l'inscription
        header("Location: inscription.html?error=Erreur lors de l'inscription");
        exit;
    }

    $requete->close();
    $mysqli->close();
}
?>
