<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Chargement de PHPMailer
require 'C:\wamp64\PHPMailer-master\src\Exception.php';
require 'C:\wamp64\PHPMailer-master\src\PHPMailer.php';
require 'C:\wamp64\PHPMailer-master\src\SMTP.php';

// Récupérer l'ID du trajet
$id_trajet = $_POST['id_trajet'] ?? null;
$id_reservation = $_POST['id_reservation'] ?? null;

// Démarrer la session
session_start();

if ($id_trajet) {
    // Connexion à la base de données MySQL (WampServer en localhost)
    $serveur = 'localhost';
    $utilisateur = 'root';
    $motdepasse = '';
    $basededonnees = 'tpl3info';

    $mysqli = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    if ($mysqli->connect_error) {
        die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
    }

    // Récupérer l'adresse e-mail du conducteur
    $requete = "SELECT ID_conducteur, NbPlace FROM trajet WHERE ID = ?";
    $statement = $mysqli->prepare($requete);
    $statement->bind_param("i", $id_trajet);
    $statement->execute();
    $resultat = $statement->get_result();

    if ($resultat->num_rows > 0) {
        $ligne = $resultat->fetch_assoc();
        $id_conducteur = $ligne['ID_conducteur'];
        $nb_place = $ligne['NbPlace'];

        // Récupérer l'adresse e-mail du conducteur à partir de la table utilisateur
        $requete_utilisateur = "SELECT email FROM utilisateur WHERE ID = ?";
        $statement_utilisateur = $mysqli->prepare($requete_utilisateur);
        $statement_utilisateur->bind_param("i", $id_conducteur);
        $statement_utilisateur->execute();
        $resultat_utilisateur = $statement_utilisateur->get_result();

        if ($resultat_utilisateur->num_rows > 0) {
            $ligne_utilisateur = $resultat_utilisateur->fetch_assoc();
            $email_conducteur = $ligne_utilisateur['email'];

            // Envoi de l'e-mail de confirmation avec PHPMailer
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

                $id_passager = $_SESSION['id'];

                // Récupérer les informations de l'utilisateur
                $requete_utilisateur = "SELECT Nom, Prenom FROM utilisateur WHERE ID = ?";
                $statement_utilisateur = $mysqli->prepare($requete_utilisateur);
                $statement_utilisateur->bind_param("i", $id_passager);
                $statement_utilisateur->execute();
                $resultat_utilisateur = $statement_utilisateur->get_result();

                // Remplacer le texte dans le corps du mail
                $ligne = $resultat_utilisateur->fetch_assoc();
                if ($ligne) {
                    $nom = $ligne['Nom'];
                    $prenom = $ligne['Prenom'];
                } else {
                    $nom = "Un";
                    $prenom = "utilisateur";
                }

                $mail->Body = "{$nom} {$prenom} a réservé votre trajet avec succès. Merci de ne pas répondre à ce mail.";

                // Destinataire et contenu de l'e-mail
                $mail->setFrom('covoituphf@gmail.com');
                $mail->addAddress($email_conducteur);
                $mail->Subject = 'Confirmation de réservation';
                $mail->Body = "{$nom} {$prenom} a reserve votre trajet avec succes. Merci de ne pas repondre à ce mail.";

                // Envoi de l'e-mail
                $mail->send();

                // Mise à jour de la base de données
                $nb_place--;
                $requete_mise_a_jour = "UPDATE trajet SET NbPlace = ? WHERE ID = ?";
                $statement_mise_a_jour = $mysqli->prepare($requete_mise_a_jour);
                $statement_mise_a_jour->bind_param("ii", $nb_place, $id_trajet);
                $statement_mise_a_jour->execute();

                // Insertion dans la table reservation
                $requete_insertion_reservation = "INSERT INTO reservation (id_trajet, id_passager, id_conducteur) VALUES (?, ?, ?)";
                $statement_insertion_reservation = $mysqli->prepare($requete_insertion_reservation);
                $statement_insertion_reservation->bind_param("iii", $id_trajet, $id_passager, $id_conducteur);
                $statement_insertion_reservation->execute();

                echo "Réservation confirmée. Vous allez être redirigé vers la page d'accueil dans 5 secondes.";
                header("refresh:5;url=recherche.php");
                exit;
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
            }
        } else {
            echo "Erreur lors de la récupération de l'adresse e-mail du conducteur.";
        }
    } else {
        echo "ID du trajet non trouvé.";
    }
} else {
    echo "ID du trajet non spécifié.";
}
?>
