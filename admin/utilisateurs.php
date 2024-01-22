<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href="..assets/css/styleContact.css" rel="stylesheet">
<link href="..assets/css/style.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- Favicons -->
 <link href="../assets/img/icon.png" rel="icon" >
 <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gérer les Utilisateurs</title>
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
<body style="position: fixed;">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="espace_admin.php">
            <img src="../assets/img/logo.png" width="220" height="50" class="d-inline-block align-top" alt="" style="margin-left:14px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
        <h1 class="h2">Liste des utilisateurs inscrits</h1>
    </div>
    <?php
// Affichage des messages d'alerte
if (isset($_GET["msg"])) {
  $msg = $_GET["msg"];
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  ' . $msg . '
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>
    <div class="mb-3">
    <!-- Bouton pour ajouter un écran -->    
    
    <form id="search-form"  method="POST" style="display: flex; align-items: center; margin-left: 76%;">
                        <input type="text" name="search" placeholder="Rechercher " required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
                    </form>
</div>

<table class="table table-hover text-center">
    <thead style="background-color: #4e73df; color: #ffffff;">
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Matricule</th>
            <th class="email-col">Email</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
// Inclusion du fichier de configuration contenant les paramètres de connexion
include "../config.php";

try {
    $connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $users = [];
    $errorMsg = "";
    $searchTerm = '';
    // Vérification si le formulaire de recherche a été soumis
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $query = "SELECT * FROM suiviecrans.users 
                WHERE username LIKE :search 
                OR matricule LIKE :search 
                OR email LIKE :search 
                OR telephone LIKE :search 
                OR adresse LIKE :search";
        $stmt = $connection->prepare($query);
        $stmt->execute(['search' => '%' . $searchTerm . '%']);
        $users = $stmt->fetchAll();

        if (empty($users)) {
            $errorMsg = 'Aucun résultat trouvé pour le terme de recherche "' . htmlspecialchars($searchTerm) . '".';
        }
    } else {
        // Récupération de tous les utilisateurs
        $query = "SELECT * FROM suiviecrans.users";
        $stmt = $connection->query($query);
        $users = $stmt->fetchAll();
    }

    // Pagination
    $itemsPerPage = 6;
    $totalItems = count($users);
    $totalPages = ceil($totalItems / $itemsPerPage);

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $currentPage = intval($_GET['page']);
    } else {
        $currentPage = 1;
    }

    $offset = ($currentPage - 1) * $itemsPerPage;
    $query = "SELECT * FROM suiviecrans.users 
                WHERE username LIKE :search 
                OR matricule LIKE :search 
                OR email LIKE :search 
                OR telephone LIKE :search 
                OR adresse LIKE :search
                LIMIT :limit OFFSET :offset";
    $stmt = $connection->prepare($query);
    $stmt->bindValue(':search', '%' . $searchTerm . '%');
    $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des utilisateurs
    if (count($users) > 0) {
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['username'] . "</td>";
            echo "<td>" . $user['matricule'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . $user['telephone'] . "</td>";
            echo "<td>" . $user['adresse'] . "</td>";
            echo '<td>
                    <a href="supprimer_utilisateur.php?id=' . $user["id"] . '" class="link-delete delete-link">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>';
            echo "</tr>";
        }
    } 
} catch (PDOException $e) {
    $errorMsg = "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>


   </tbody>
   </table>
   <div class="pagination-container">
    <div class="pagination">
        <?php if ($currentPage > 1) { ?>
            <a href="?page=<?php echo $currentPage - 1; ?>" class="prev" style="text-decoration: none;">Précédent</a>
        <?php } ?>

        <?php
        // Boucle pour afficher les liens des pages de pagination
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo '<a href="#" class="active" style="text-decoration: none;">' . $i . '</a>';
            } else {
                echo '<a href="?page=' . $i . '" style="text-decoration: none;">' . $i . '</a>';
            }
        }
        ?>

        <?php if ($currentPage < $totalPages) { ?>
            <a href="?page=<?php echo $currentPage + 1; ?>" class="next" style="text-decoration: none;">Suivant</a>
        <?php } ?>
    </div>
</div>

   

    <?php if (!empty($errorMsg)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-left: 4px; margin-right: 5px; text-align: center;">
            <?php echo htmlspecialchars($errorMsg); ?>
        </div>
    <?php endif; ?>
</main>

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
</html>
