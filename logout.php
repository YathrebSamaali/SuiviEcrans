<?php
// Inclut le fichier de configuration (si présent)
@include 'config.php';

// Démarre la session
session_start();

// Efface toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page d'accueil (index.php)
header('location:index.php');
?>
