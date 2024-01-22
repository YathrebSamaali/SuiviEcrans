<!DOCTYPE html>
<html>
<head>
    <title>Résultats de recherche</title>
    <!-- Favicons -->
    <link href="assets/img/icon.png" rel="icon">
    <link href="assets/css/styleContact.css" rel="stylesheet">

    <!-- Stylesheet for table formatting and back icon -->
    <style>
        /* Ajoutez votre CSS personnalisé ici */
    </style>

    <!-- Lien vers Font Awesome pour l'utilisation des icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!-- Section de navigation avec bouton de retour -->
    <nav>
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" style="text-decoration: none; display: inline-block;margin-left: 5%;margin-top:2%; padding: 10px; font-size: 18px; font-weight: bold; border: 2px solid blue; border-radius: 20px;">
            <span class="back-icon" style="color: blue; font-size: 16px;  margin-right: 10px;cursor: pointer;"><i class="fas fa-arrow-left"></i></span> <span style="color: blue;">Retour</span>
        </a>
    </nav>
    
    <!-- Titre des résultats de recherche -->
    <div style="margin-left: 5%;">
        <h1>Résultats de recherche</h1>
    </div>

    <?php
    // Inclure la configuration de connexion à la base de données
    require_once 'config.php';

    try {
        // Créer une nouvelle instance PDO
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer la valeur de recherche
        $search = $_POST['search'];

        // Modifier la requête SQL pour utiliser ILIKE pour une recherche de texte partiel insensible à la casse
        $query = "SELECT * FROM suiviecrans.ecrans WHERE numero_ecran ILIKE :search";
        $stmt = $pdo->prepare($query);

        // Lier le paramètre de recherche avec des symboles '%'
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        

        // Afficher les résultats de la recherche dans un tableau
        if ($stmt->rowCount() > 0) {
            echo '<table style="border-collapse: collapse; width: 88%; margin-left: 5%;">';
            echo '<tr><th style="background-color: #5a5af3; color: white; width: 20%;">Numéro d\'écran</th><th style="background-color: #5a5af3; color: white; width: 20%;">Référence</th><th style="background-color: #5a5af3; color: white; width: 20%;">Emplacement</th><th style="background-color: #5a5af3; color: white; width: 20%;">Produit</th><th style="background-color: #5a5af3; color: white; width: 20%;">Face</th></tr>';
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['numero_ecran'] . '</td>';
                echo '<td>' . $row['ref'] . '</td>';

                // Vérifier si la colonne "emplacement" correspond aux critères de recherche
                if (stripos($row['emplacement'], $search) !== false || stripos($row['numero_ecran'], $search) !== false || stripos($row['produit'], $search) !== false) {
                    echo '<td class="highlight">' . $row['emplacement'] . '</td>';
                } else {
                    echo '<td>' . $row['emplacement'] . '</td>';
                }

                echo '<td>' . $row['produit'] . '</td>';
                echo '<td>' . $row['face'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<script>alert("Aucun résultat trouvé."); window.location.href = "index.php";</script>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    ?>
</body>
</html>
