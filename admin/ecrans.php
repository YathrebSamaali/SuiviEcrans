<?php
// Démarrer la session pour gérer les sessions utilisateur
session_start();

// Inclure le fichier de configuration
require_once '../config.php'; // Assurez-vous que le chemin est correct pour accéder au fichier config.php

// Nombre de résultats par page pour la pagination
$resultsPerPage = 6;

try {
    // Connexion à la base de données PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le terme de recherche saisi par l'utilisateur
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    // Requête SQL pour récupérer les données filtrées en fonction du terme de recherche
    $sql = "SELECT * FROM suiviecrans.ecrans WHERE 
                CAST(numero_ecran AS TEXT) LIKE :search OR
                emplacement LIKE :search OR
                produit LIKE :search OR
                ref LIKE :search OR
                face LIKE :search";
    
    // Préparer et exécuter la requête avec le terme de recherche
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':search' => "%$search%"));
    $ecrans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si la recherche n'a renvoyé aucun résultat
    if (empty($ecrans)) {
        $errorMsg = 'Aucun résultat trouvé pour le terme de recherche "' . htmlspecialchars($search) . '".';
    }

    // Pagination
    $total_results = count($ecrans);
    $total_pages = ceil($total_results / $resultsPerPage);
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $resultsPerPage;
    $ecrans = array_slice($ecrans, $offset, $resultsPerPage);

} catch (PDOException $e) {
    // Afficher un message d'erreur en cas de problème de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- CSS Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Favicons -->
  <link href="../assets/img/icon.png" rel="icon" >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="..assets/css/styleContact.css" rel="stylesheet">
<link href="..assets/css/style.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">

<title>Gèrer les écrans</title>
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
</head>
<!-- L'en-tête de la page -->
<body style="position: fixed; width: 100%">


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
        <h1 class="h2">Gèrer les écrans de sérigraphie</h1>
    </div>


<!-- Contenu principal -->
<div >
  <?php
  // Affichage des messages d'alerte
  if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    ' . $msg . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  ?>


 <!-- Boutons d'action et barre de recherche -->
<div class="mb-3">
    <!-- Bouton pour ajouter un écran -->
    <a href="ajouter.php" class="btn btn-add"><i class="fas fa-plus"></i> Ajouter un écran</a>
    
    
    <form id="search-form"  method="POST" style="display: flex; align-items: center; margin-left: 76%;">
                        <input type="text" name="search" placeholder="Rechercher " required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
                    </form>
</div>

  <!-- Tableau affichant les résultats -->
  <table class="table table-hover text-center">
    <thead class="table-dark">
      <tr>
      
        <th scope="col">N°écrans de sérigraphie</th>
        <th scope="col">Emplacement</th>
        <th scope="col">Produit</th>
        <th scope="col">Référence</th>
        <th scope="col">Face</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
  <tbody>
  <?php
  // Utilisation d'une boucle foreach pour parcourir chaque élément du tableau $ecrans
  foreach ($ecrans as $ecran) {
  ?>
    <!-- Début d'une ligne du tableau -->
    <tr>
      <!-- Affichage du numéro de l'écran de sérigraphie -->
      <td><?php echo $ecran["numero_ecran"] ?></td>
      <!-- Affichage de l'emplacement de l'écran -->
      <td><?php echo $ecran["emplacement"] ?></td>
      <!-- Affichage du produit lié à l'écran -->
      <td><?php echo $ecran["produit"] ?></td>
      <!-- Affichage de la référence de l'écran -->
      <td><?php echo $ecran["ref"] ?></td>
      <!-- Affichage de la face de l'écran -->
      <td><?php echo $ecran["face"] ?></td>
      <!-- Cellule pour les actions (éditer et supprimer) -->
      <td>
        <!-- Lien pour éditer l'écran -->
        <a href="modifier.php?id=<?php echo $ecran["id"]; ?>" class="link-edit edit-link"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
        <!-- Lien pour supprimer l'écran -->
        <a href="supprimer.php?id=<?php echo $ecran["id"] ?>" class="link-delete delete-link"><i class="fa-solid fa-trash fs-5"></i></a>
      </td>
    </tr>
    <!-- Fin de la ligne du tableau -->
  <?php } ?>
  </tbody>
  </table>

  <!-- Pagination -->
  <div class="pagination-container">
  <div class="pagination">
    <?php if ($current_page > 1) { ?>
      <!-- Affiche un lien "Précédent" seulement si la page actuelle est supérieure à 1 -->
      <a href="?page=<?php echo $current_page - 1; ?>" class="prev">Précédent</a>
    <?php } ?>

    <?php
    // Boucle pour afficher les liens des pages de pagination
    for ($i = 1; $i <= $total_pages; $i++) {
    ?>
      <?php if ($i == $current_page) { ?>
        <!-- Lien pour la page actuelle (marqué comme actif) -->
        <a href="#" class="active"><?php echo $i; ?></a>
      <?php } else { ?>
        <!-- Lien pour les autres pages -->
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
      <?php } ?>
    <?php
    }
    ?>

    <?php if ($current_page < $total_pages) { ?>
      <!-- Affiche un lien "Suivant" seulement si la page actuelle est inférieure au nombre total de pages -->
      <a href="?page=<?php echo $current_page + 1; ?>" class="next">Suivant</a>
    <?php } ?>
  </div>
  </div>

  <!-- Affichage du message d'erreur -->
  <?php if (!empty($errorMsg)) : ?>
    <!-- Vérifie si la variable $errorMsg contient du texte (c'est-à-dire s'il y a un message d'erreur) -->
    <div class="alert alert-danger" role="alert" style="margin-left: 4px;margin-right: 5px;text-align: center;">
      <!-- La classe "alert alert-danger" ajoute un fond rouge à la boîte d'alerte -->
      <?php echo htmlspecialchars($errorMsg); ?>
      <!-- La fonction htmlspecialchars est utilisée pour échapper les caractères spéciaux et éviter les vulnérabilités XSS -->
    </div>
  <?php endif; ?>

</div>

</div>
    </div>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Suppression d'un écran
const deleteLinks = document.querySelectorAll('.delete-link');
deleteLinks.forEach(link => {    //Cette méthode forEach parcourt tous les éléments sélectionnés 
  link.addEventListener('click', (e) => {   //Lorsqu'un lien est cliqué, l'événement "click" est déclenché, et la fonction fléchée (callback) est exécutée. 
    e.preventDefault(); //Cela empêche le comportement par défaut du lien. Dans ce cas, il empêche la navigation vers un autre lien.
    // Demande de confirmation avant la suppression
    const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cet écran ?");
    if (confirmDelete) {
      // Redirection vers la page de suppression en utilisant l'attribut href du lien
      window.location.href = link.getAttribute('href');
    }
  });
});


</script>
</body>
