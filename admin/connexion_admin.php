<?php
// Inclure le fichier de configuration
require_once '../config.php';

// Connexion à la base de données
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Vérification de la connexion
if (!$conn) {
    echo "La connexion a échoué.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des informations d'identification dans la base de données des administrateurs
    $query = "SELECT * FROM suiviecrans.admins WHERE username='$username' AND password='$password'";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo "Une erreur s'est produite lors de la requête.";
        exit;
    }

    $row = pg_fetch_assoc($result);
    if ($row) {
        // L'administrateur est authentifié avec succès
        // Redirection vers la page espace_admin.php
        header("Location: espace_admin.php");
        exit;
    } else {
        // Afficher le message d'erreur en rouge
        echo '<p style="color: red;">Nom d\'utilisateur ou mot de passe incorrect</p>';
    }
}

pg_close($conn);
?>