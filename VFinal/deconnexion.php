<?php
session_start(); // Démarre la session

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    // Si l'utilisateur est connecté, déconnectez-le
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session

    // Redirigez l'utilisateur vers la page d'accueil
    header("Location: recherche.php"); // Remplacez par la page de connexion
} 
?>
