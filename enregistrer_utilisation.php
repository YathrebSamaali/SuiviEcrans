<?php
// Inclure le fichier de configuration
require_once 'config.php';

// Crée une connexion
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Vérifie la connexion
if (!$conn) {
    // Affiche une alerte en cas d'échec de connexion et redirige vers 'utilisation.php'
    die("<script>alert('Connexion échouée: " . pg_last_error() . "'); window.location.href = 'utilisation.php';</script>");
}

// Vérifie si le formulaire a été soumis
if (isset($_POST['operation'])) {
    // Récupère les valeurs des attributs selon l'opération choisie
    $operation = $_POST['operation'];

    if ($operation == "misenprod") {
        // Récupère les valeurs spécifiques à l'opération 'Mise en production'
        $matricule = $_POST['matricule'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
        $equipe = $_POST['equipe'];
        $numero_ecran = $_POST['numero_ecran'];
        $numero_ligne_cms = $_POST['numero_ligne_cms'];
        $date = $_POST['date'];
        $commentaire = $_POST['commentaire'];
    } elseif ($operation == "findeprod") {
        // Récupère les valeurs spécifiques à l'opération 'Fin de production'
        $matricule = $_POST['matricule'];
        $etat = $_POST['etat'];
        $date = $_POST['date'];
        $equipe = $_POST['equipe'];
        $numero_ecran = $_POST['numero_ecran'];
        $numero_ligne_cms = $_POST['numero_ligne_cms'];
        $date = $_POST['date'];
        $commentaire = $_POST['commentaire'];
    } elseif ($operation == "nettoyage") {
        // Récupère les valeurs spécifiques à l'opération 'Nettoyage'
        $matricule = $_POST['matricule'];
        $numero_ecran = $_POST['numero_ecran'];
        $date = $_POST['date'];
        $numero_ligne_cms = "NA";
        $equipe = "NA";
        $date = $_POST['date'];
        $etat = $_POST['etat'];
        $commentaire = $_POST['commentaire'];
    }

    // Échappe les caractères spéciaux pour éviter les problèmes d'injection SQL
    $operation = pg_escape_string($operation);
    $matricule = pg_escape_string($matricule);
    $etat = pg_escape_string($etat);
    $equipe = pg_escape_string($equipe);
    $numero_ecran = pg_escape_string($numero_ecran);
    $numero_ligne_cms = pg_escape_string($numero_ligne_cms);
    $date = pg_escape_string($date);
    $commentaire = pg_escape_string($commentaire);

    // Insère les données dans la table de base
    $sql = "INSERT INTO suiviecrans.utilisation (matricule, operation, numero_ecran, etat, numero_ligne_cms, date, equipe, commentaire)
            VALUES ('$matricule', '$operation', '$numero_ecran', '$etat', '$numero_ligne_cms', '$date', '$equipe', '$commentaire')";

    // Exécute la requête SQL
    $result = pg_query($conn, $sql);
    if ($result) {
        // Affiche une alerte en cas de succès d'insertion et redirige vers 'utilisation.php'
        echo "<script>alert('Les informations ont été enregistrées avec succès.'); window.location.href = 'utilisation.php';</script>";
    } else {
        // Affiche une alerte en cas d'erreur d'insertion et redirige vers 'utilisation.php'
        echo "<script>alert('Erreur lors de l\'insertion des données: " . pg_last_error($conn) . "'); window.location.href = 'utilisation.php';</script>";
    }
}

// Ferme la connexion
pg_close($conn);
?>
