<?php
// Inclusion du fichier de configuration contenant les paramètres de connexion à la base de données
include "../config.php";

$errorMsg = "";

try {
    // Établissement de la connexion à la base de données PostgreSQL en utilisant PDO
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    // Configuration du mode d'affichage des erreurs en mode exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affichage du message d'erreur et sortie du script
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

// Vérification si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Extraction des valeurs du formulaire
    $numero_ecran = $_POST['numero_ecran'];
    $emplacement = $_POST['emplacement'];
    $produit = $_POST['produit'];
    $ref = $_POST['ref'];
    $face = $_POST['face'];

    // Vérification si des champs sont vides
    if (empty($numero_ecran) || empty($emplacement) || empty($produit) || empty($ref) || empty($face)) {
        $errorMsg = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!preg_match('/^\d{4}$/', $numero_ecran)) {
        $errorMsg = "Le numéro d'écran doit contenir exactement 4 chiffres.";
    } else {
        // Vérification de l'existence du numéro d'écran
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM suiviecrans.ecrans WHERE numero_ecran = :numero_ecran");
        $stmt_check->execute([':numero_ecran' => $numero_ecran]);
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            $errorMsg = "Cette écran existe déjà avec ce numéro d'écran.";
        } else {
            try {
                // Préparation de la requête SQL d'insertion avec des paramètres nommés
                $stmt = $pdo->prepare("INSERT INTO suiviecrans.ecrans (numero_ecran, emplacement, produit, ref, face)
                    VALUES (:numero_ecran, :emplacement, :produit, :ref, :face)");
                // Exécution de la requête avec les valeurs des paramètres
                $stmt->execute([
                    ':numero_ecran' => $numero_ecran,
                    ':emplacement' => $emplacement,
                    ':produit' => $produit,
                    ':ref' => $ref,
                    ':face' => $face
                ]);

                // Redirection vers la page admin avec un message de succès en paramètre de requête
                header("Location: ecrans.php?msg=Écran ajouté avec succès");
                exit();
            } catch (PDOException $e) {
                // En cas d'erreur lors de l'insertion, affichage du message d'erreur et sortie du script
                echo "Erreur : " . $e->getMessage();
                exit();
            }
        }
    }
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="espace_admin.php" style="display: flex; justify-content: center; width: 16%;">
            <img src="../assets/img/logo.png" width="220" height="50" class="d-inline-block align-top" alt="">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto" style="margin-right: 20px;">
                <li class="nav-item">
                    <a class="nav-link" href="ecrans.php"><i class="fas fa-arrow-left"></i> Retour</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3 style="margin-top: 30px;">Ajouter un nouvel écran</h3>
            <p class="text-muted">Remplissez le formulaire ci-dessous pour ajouter un nouvel écran</p>
            <?php if ($errorMsg) : ?>
                <p class="error-message" style="color: red;"><?php echo $errorMsg; ?></p>
            <?php endif; ?>
        </div>

        <!-- Formulaire d'ajout d'écran -->
        <div class="container d-flex justify-content-center">
            <form action="ajouter.php" method="post" style="width: 50vw; min-width: 300px;">
                <!-- Champ: Numéro d'écran de sérigraphie -->
                <div class="mb-3">
                    <label class="form-label">Numéro écran de sérigraphie :</label>
                    <input type="number" class="form-control" name="numero_ecran">
                </div>

                <!-- Champ: Emplacement -->
                <div class="mb-3">
                    <label class="form-label">Emplacement :</label>
                    <select class="form-select" name="emplacement">
                        <option value="c1">C1</option>
                        <option value="c2">C2</option>
                        <option value="c3">C3</option>
                        <option value="c4">C4</option>
                        <option value="d5">D5</option>
                        <option value="d1">D1</option>
                    </select>
                </div>

                <!-- Champ: Produit -->
                <div class="mb-3">
                    <label class="form-label">Produit :</label>
                    <input type="text" class="form-control" name="produit">
                </div>

                <!-- Champ: Référence -->
                <div class="mb-3">
                    <label class="form-label">Référence :</label>
                    <input type="text" class="form-control" name="ref">
                </div>

                <!-- Champ: Face -->
                <div class="mb-3">
                    <label class="form-label">Face :</label>
                    <select class="form-select" name="face">
                        <option value="p1">P1</option>
                        <option value="p2">P2</option>
                    </select>
                </div>

                <!-- Boutons: Enregistrer et Annuler -->
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Enregistrer</button>
                    <a href="ecrans.php" class="btn btn-danger">Annuler</a>
                </div>
            </form>
        </div>
    </div>



    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


