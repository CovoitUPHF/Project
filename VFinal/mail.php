<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\wamp64\PHPMailer-master\src\Exception.php';
require 'C:\wamp64\PHPMailer-master\src\PHPMailer.php';
require 'C:\wamp64\PHPMailer-master\src\SMTP.php';

$serveur = 'localhost';
$utilisateur = 'root';
$motdepasse = '';
$basededonnees = 'tpl3info';

$mysqli = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

if ($mysqli->connect_error) {
    die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
}

$email_destinataire = null;
$requete_destinataire = "SELECT email FROM utilisateur WHERE ID = ?";
$statement_destinataire = $mysqli->prepare($requete_destinataire);
$statement_destinataire->bind_param("i", $_POST['id_utilisateur']);
$statement_destinataire->execute();
$resultat_destinataire = $statement_destinataire->get_result();

if ($resultat_destinataire->num_rows > 0) {
    $ligne_destinataire = $resultat_destinataire->fetch_assoc();
    $email_destinataire = $ligne_destinataire['email'];
}

$mail = new PHPMailer(true);

try {
    // Paramètres SMTP Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'covoituphf@gmail.com';
    $mail->Password = 'flwk pwdo wpiy qfic';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Désactiver la vérification du certificat SSL
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Destinataire et contenu de l'e-mail
    $mail->setFrom('covoituphf@gmail.com');
    if ($email_destinataire) {
        $mail->addAddress($email_destinataire);
    } else {
        echo "Erreur lors de la récupération de l'adresse email du destinataire.";
    }
    $mail->Subject = 'Nouveau message de contact';
    $mail->Body = $_POST['message'];

    // Envoi de l'e-mail
    $mail->send();

    echo '<p>Votre message a bien été envoyé.</p>';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
}
?>
