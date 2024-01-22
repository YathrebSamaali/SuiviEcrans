<?php
// Inclusion du fichier de configuration contenant les paramètres de connexion
include "../config.php";

// Récupération de l'ID à partir des paramètres GET
$id = $_GET["id"];

try {
    // Création d'une nouvelle connexion à la base de données PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    
    // Configuration de l'attribut d'affichage des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();  // Arrêter l'exécution du script en cas d'échec de la connexion
}

try {
    // Préparation et exécution de la requête DELETE pour supprimer une entrée dans la table "ecrans"
    $stmt = $pdo->prepare("DELETE FROM suiviecrans.users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirection vers la page d'administration avec un message de succès
    header("Location: utilisateurs.php?msg=Utilisateur supprimé avec succès");
    exit();
} catch (PDOException $e) {
    // Gestion des erreurs en cas d'échec de la suppression
    echo "Échec : " . $e->getMessage();
    exit();
}
?>
