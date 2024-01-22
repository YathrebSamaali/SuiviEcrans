<?php
// Paramètres de connexion à la base de données
$host = 'localhost';      // Adresse de l'hôte de la base de données
$port = '5432';           // Numéro de port de la base de données (PostgreSQL par défaut)
$dbname = 'postgres';     // Nom de la base de données
$user = 'postgres';       // Nom d'utilisateur pour se connecter à la base de données
$password = '123';        // Mot de passe pour se connecter à la base de données

try {
    // Création d'une nouvelle connexion à la base de données PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");

    // Configuration de l'attribut d'affichage des erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();  // Arrêter l'exécution du script en cas d'échec de la connexion
}
?>
