<?php
// Inclure le fichier de configuration
require_once '../config.php';

// Initialiser les variables
$searchTerm = ''; // Terme de recherche par défaut
$errorMsg = ''; // Message d'erreur par défaut

// Vérifier si le formulaire de recherche a été soumis
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search']; // Récupérer le terme de recherche

    try {
        // Créer une connexion à la base de données
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour récupérer les enregistrements correspondant au terme de recherche
        $query = "SELECT * FROM suiviecrans.utilisation WHERE 
                  matricule LIKE :searchTerm OR 
                  numero_ecran LIKE :searchTerm OR 
                  etat LIKE :searchTerm OR 
                  operation LIKE :searchTerm ";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        $operations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si aucun résultat n'a été trouvé
        if (empty($operations) && !empty($searchTerm)) {
            $errorMsg = 'Aucun résultat trouvé pour le terme de recherche "' . htmlspecialchars($searchTerm) . '".';
        }
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête
        $errorMsg = 'Erreur lors de l\'exécution de la requête : ' . $e->getMessage();
        // En cas d'erreur, définir $operations comme un tableau vide pour éviter l'affichage incorrect de la table
        $operations = [];
    }
} else {
    // Requête pour récupérer tous les enregistrements de la table "utilisation"
    try {
        // Créer une connexion à la base de données
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM suiviecrans.utilisation";
        $stmt = $pdo->query($query);
        $operations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // En cas d'erreur lors de la récupération des données
        $errorMsg = 'Erreur lors de la récupération des données : ' . $e->getMessage();
    }
}

// Nombre d'opérations à afficher par page
$itemsPerPage = 3;

// Numéro de la page demandée
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1; // Par défaut, afficher la première page
}

// Calcul du nombre total d'opérations
$totalItems = count($operations);

// Calcul du nombre total de pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Calcul de l'indice de début pour la requête SQL
$offset = ($currentPage - 1) * $itemsPerPage;

// Requête SQL avec pagination
$query = "SELECT * FROM suiviecrans.utilisation 
          WHERE 
          matricule LIKE :searchTerm OR 
          numero_ecran LIKE :searchTerm OR 
          etat LIKE :searchTerm OR 
          operation LIKE :searchTerm OR 
          CAST(date as text) LIKE :searchTerm OR 
          commentaire LIKE :searchTerm OR 
          numero_ligne_cms LIKE :searchTerm OR 
          equipe LIKE :searchTerm 
          LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
$stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$operations = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ...
?>


<!DOCTYPE html>
<html>
<head>
<title>Historique d'utilisation</title>
<!-- CSS Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- Favicons -->
<link href="../assets/img/icon.png" rel="icon" >
 <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link href="..assets/css/styleContact.css" rel="stylesheet">
<link href="..assets/css/style.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">

<script>
        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("search-form").submit();
            }
        }
  </script>
<style>


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body style=" position:fixed">


<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="espace_admin.php">
            <img src="../assets/img/logo.png" width="220" height="50" class="d-inline-block align-top" alt="">
    
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="row">
        <div class="row">
        <nav class="col-md-2 d-md-block sidebar">
    <div class="sidebar-sticky">
    <div class="d-flex flex-column align-items-center p-3">
            <img src="../assets/img/user.png" alt="Avatar" class="avatar" style="width: 50px; height: 50px; border-radius: 50%;">
            <p >Yathreb Samaali</p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="espace_admin.php"><i class="fas fa-chart-bar"></i>  Tableau de bord <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ecrans.php"><i class="fas fa-cogs"></i>  Gérer les Écrans</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="utilisateurs.php"><i class="fas fa-user-cog"></i>  Gérer les Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="historique.php"><i class="fas fa-chart-pie"></i>  Suivi l'utilisation</a>
            </li>
        </ul>
    </div>
</nav>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Suivi d'utilisation des écrans de sérigraphie</h1>
    </div>

    <div class="export-buttons">
        <button class="excel-button" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Exporter en Excel</button>
        <button class="pdf-button" onclick="exportToPDF()"><i class="fas fa-file-pdf"></i> Exporter en PDF</button>
        <form id="search-form"  method="POST" style="display: flex; align-items: center; margin-left: 76%;">
                        <input type="text" name="search" placeholder="Rechercher " required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
                    </form>
    </div>

    <table>
        <tr>
            <th>Matricule</th>
            <th>Numéro d'écran</th>
            <th>État</th>
            <th>Type d'opération</th>
            <th>Date</th>
            <th>Commentaire</th>
            <th>Numéro de ligne CMS</th>
            <th>Équipe</th>
        </tr>
        <?php
        // Parcours de chaque opération dans le tableau $operations
        foreach ($operations as $operation) {
            echo '<tr>'; // Début de la ligne du tableau
            echo '<td>' . $operation['matricule'] . '</td>'; // Affichage de la valeur dans la colonne "Matricule"
            echo '<td>' . $operation['numero_ecran'] . '</td>'; // Affichage de la valeur dans la colonne "Numéro d'écran"
            echo '<td>' . $operation['etat'] . '</td>'; // Affichage de la valeur dans la colonne "État"
            echo '<td>' . $operation['operation'] . '</td>'; // Affichage de la valeur dans la colonne "Type d'opération"
            echo '<td>' . $operation['date'] . '</td>'; // Affichage de la valeur dans la colonne "Date"
            echo '<td>' . $operation['commentaire'] . '</td>'; // Affichage de la valeur dans la colonne "Commentaire"
            echo '<td>' . $operation['numero_ligne_cms'] . '</td>'; // Affichage de la valeur dans la colonne "Numéro de ligne CMS"
            echo '<td>' . $operation['equipe'] . '</td>'; // Affichage de la valeur dans la colonne "Équipe"
            echo '</tr>'; // Fin de la ligne du tableau
        }
        ?>
    </table>

    <!-- Affichage de la pagination -->
    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination">
            <?php if ($currentPage > 1) { ?>
                <a href="?page=<?php echo $currentPage - 1; ?>" class="prev">Précédent</a>
            <?php } ?>

            <?php
            // Boucle pour afficher les liens des pages de pagination
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    echo '<a href="#" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
            }
            ?>

            <?php if ($currentPage < $totalPages) { ?>
                <a href="?page=<?php echo $currentPage + 1; ?>" class="next">Suivant</a>
            <?php } ?>
        </div>
    </div>

    <?php if (!empty($errorMsg)) : ?>
        <div class="alert alert-danger" role="alert" style="text-align: center;">
            <?php echo htmlspecialchars($errorMsg); ?>
        </div>
    <?php endif; ?>
</main>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    // Fonction pour exporter les données du tableau au format Excel
    function exportToExcel() {
        const table = document.querySelector('table'); // Sélectionne le tableau
        let html = table.outerHTML; // Récupère le HTML du tableau
        const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html); // Crée l'URL avec le contenu Excel
        const link = document.createElement('a'); // Crée un élément <a> pour le téléchargement
        link.href = url; // Définit l'URL du lien
        link.download = 'historique_d\'utilisation.xls'; // Définit le nom du fichier de téléchargement
        link.click(); // Déclenche le téléchargement en cliquant sur le lien
    }

    // Fonction pour exporter les données du tableau au format PDF
    function exportToPDF() {
        const table = document.querySelector('table'); // Sélectionne le tableau
        const opt = {
            margin: 1,
            filename: 'historique_d\'utilisation.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        // Utilise la bibliothèque html2pdf pour générer le PDF à partir du tableau
        html2pdf().from(table).set(opt).save(); // Génère et sauvegarde le PDF
    }
</script>
</body>
</html>
