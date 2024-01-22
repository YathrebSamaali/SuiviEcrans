<?php
// Inclusion du fichier de configuration contenant les paramètres de connexion
include "../config.php";

// Définition de la variable d'erreur
$errorMsg = "";

// Récupération de l'ID à partir des paramètres GET
$id = $_GET["id"];

// Vérification si le formulaire de mise à jour a été soumis
if (isset($_POST["submit"])) {
    // Récupération des valeurs du formulaire
    $numero_ecran = $_POST['numero_ecran'];
    $emplacement = $_POST['emplacement'];
    $produit = $_POST['produit'];
    $ref = $_POST['ref'];
    $face = $_POST['face'];

    // Vérification des champs vides
    if (empty($numero_ecran) || empty($emplacement) || empty($produit) || empty($ref) || empty($face)) {
        $errorMsg = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!preg_match('/^\d{4}$/', $numero_ecran)) {
        $errorMsg = "Le numéro d'écran doit contenir exactement 4 chiffres.";
    } else {
        try {
            // Création d'une nouvelle connexion à la base de données PostgreSQL
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
            // Configuration de l'attribut d'affichage des erreurs
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation et exécution de la requête UPDATE pour mettre à jour les données de l'écran
            $stmt = $pdo->prepare("UPDATE suiviecrans.ecrans SET numero_ecran=:numero_ecran, emplacement=:emplacement, produit=:produit, ref=:ref, face=:face WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':numero_ecran', $numero_ecran);
            $stmt->bindParam(':emplacement', $emplacement);
            $stmt->bindParam(':produit', $produit);
            $stmt->bindParam(':ref', $ref);
            $stmt->bindParam(':face', $face);
            $stmt->execute();

            // Redirection vers la page d'administration avec un message de succès
            header("Location: ecrans.php?msg=Données mises à jour avec succès");
            exit();
        } catch (PDOException $e) {
            // Gestion des erreurs en cas d'échec de la mise à jour
            $errorMsg = "Erreur : " . $e->getMessage();
        }
    }
}

try {
    // Création d'une nouvelle connexion à la base de données PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    // Configuration de l'attribut d'affichage des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation et exécution de la requête SELECT pour récupérer les données de l'écran à mettre à jour
    $stmt = $pdo->prepare("SELECT * FROM suiviecrans.ecrans WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gestion des erreurs en cas d'échec de la récupération des données
    $errorMsg = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Favicons -->
  <link href="../assets/img/icon.png" rel="icon" >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Ajouter un nouvel écran</title>
<title>Modifier les informations des écrans</title>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="espace_admin.php" style="display: flex; justify-content: center; width: 16%;">
            <img src="../assets/img/logo.png" width="220" height="50" class="d-inline-block align-top" alt="">
    
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            <ul class="navbar-nav ml-auto" style="margin-right: 20px;">
                <li class="nav-item">
                    <a class="nav-link" href="ecrans.php"><i class="fas fa-arrow-left"></i> Retour</a>
                </li>
            </ul>
        </div>
    </nav>

  <div class="container">
  <div class="text-center mb-4">
    <!-- Titre et instructions -->
    <h3 style="margin-top:30px;">Modifier les informations des écrans</h3>
    <p class="text-muted">Cliquez sur "Mettre à jour" après avoir modifié les informations</p>
    <?php if ($errorMsg) : ?>
      <p class="error-message" style="color: red;"><?php echo $errorMsg; ?></p>
    <?php endif; ?>
  </div>

    <div class="container d-flex justify-content-center">
      <!-- Formulaire de mise à jour des informations -->
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <!-- Champ pour le numéro d'écran -->
          <div class="col">
            <label class="form-label">Numéro :</label>
            <input type="number" class="form-control" name="numero_ecran" value="<?php echo $row['numero_ecran'] ?>">
          </div>
          <!-- Liste déroulante pour l'emplacement -->
          <div class="col">
            <label class="form-label">Emplacement :</label>
            <select class="form-select" name="emplacement" required>
              <!-- Options pour l'emplacement avec sélection basée sur la valeur de la base de données -->
              <option value="c1" <?php echo ($row['emplacement'] == 'c1') ? 'selected' : '' ?>>C1</option>
              <option value="c2" <?php echo ($row['emplacement'] == 'c2') ? 'selected' : '' ?>>C2</option>
              <option value="c3" <?php echo ($row['emplacement'] == 'c3') ? 'selected' : '' ?>>C3</option>
              <option value="c4" <?php echo ($row['emplacement'] == 'c4') ? 'selected' : '' ?>>C4</option>
              <option value="d1" <?php echo ($row['emplacement'] == 'd1') ? 'selected' : '' ?>>D1</option>
              <option value="d5" <?php echo ($row['emplacement'] == 'd5') ? 'selected' : '' ?>>D5</option>
            </select>
          </div>
        </div>

        <!-- Champ pour le produit -->
        <div class="mb-3">
          <label class="form-label">Produit :</label>
          <input type="text" class="form-control" name="produit" value="<?php echo $row['produit'] ?>" >
        </div>

        <!-- Champ pour la référence -->
        <div class="mb-3">
          <label class="form-label">Référence :</label>
          <input type="text" class="form-control" name="ref" value="<?php echo $row['ref'] ?>">
        </div>

        <!-- Liste déroulante pour la face -->
        <div class="mb-3">
          <label class="form-label">Face :</label>
          <select class="form-select" name="face" >
            <!-- Options pour la face avec sélection basée sur la valeur de la base de données -->
            <option value="p1" <?php echo ($row['face'] == 'p1') ? 'selected' : '' ?>>P1</option>
            <option value="p2" <?php echo ($row['face'] == 'p2') ? 'selected' : '' ?>>P2</option>

            <!-- Autres options pour la face -->
          </select>
        </div>

        <!-- Boutons de soumission et d'annulation -->
        <div>
          <button type="submit" class="btn btn-success" name="submit">Mettre à jour</button>
          <a href="ecrans.php" class="btn btn-danger">Annuler</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
