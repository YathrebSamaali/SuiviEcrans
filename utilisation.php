<?php
require_once 'config.php';
try {
    // Créer une instance PDO pour se connecter à la base de données
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les numéros d'écran depuis la table 'ecrans'
    $query = "SELECT numero_ecran FROM suiviecrans.ecrans";
    $stmt = $conn->query($query);
    $ecrans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour récupérer les matricules depuis la table 'suiviecrans.users'
    $query = "SELECT matricule FROM suiviecrans.users";
    $stmt = $conn->query($query);
    $matricules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de la requête
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enregistrer une utilisation</title>
  <link rel="stylesheet" href="style.css">
  <!-- CSS de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- CSS de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <!--font answone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-**********" crossorigin="anonymous" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/styleContact.css" rel="stylesheet">

  <!--js-->
  <script src="assets/js/script.js"></script>
  <script src="assets/js/main.js"></script>
  <!-- Favicons -->
  <link href="assets/img/icon.png" rel="icon" >
  <!--font answone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-**********" crossorigin="anonymous" />
  
  <script>
    // Vérification des messages de succès et d'erreur provenant du PHP
    <?php if (!empty($successMessage)): ?>
        // Si un message de succès est présent, affiche une alerte avec le message
        alert('<?php echo $successMessage; ?>');
        // Redirige l'utilisateur vers 'utilisation.php' (remplacez par l'URL de la page de redirection appropriée)
        window.location.href = 'utilisation.php';
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        // Si un message d'erreur est présent, affiche une alerte avec le message
        alert('<?php echo $errorMessage; ?>');
    <?php endif; ?>
  </script>

  
  <script>
    // Cette fonction est appelée lorsque l'utilisateur appuie sur une touche
    function handleKeyPress(event) {
        // Vérifie si la touche pressée est la touche "Enter" (code 13)
        if (event.keyCode === 13) {
            // Empêche le comportement par défaut de la touche "Enter"
            event.preventDefault();
            // Soumet le formulaire avec l'ID "search-form"
            document.getElementById("search-form").submit();
        }
    }
  </script>   

</head>
<body>
<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center justify-content-between">
  <a href="espace_utilisateur.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>

    
    <!-- Navigation -->
    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="espace_utilisateur.php" style="margin-top:20px;">Accueil</a></li>
        
        <!-- Liens de navigation -->
        <li><a class="nav-link scrollto" href="utilisation.php" style="margin-top:20px;">Enregistrer une utilisation</a></li>
        <li><a class="nav-link scrollto" href="#contact" style="margin-top:20px;">Contact</a></li>
        
        <!-- Zone de recherche -->
        <li class="mr-3">
        <form id="search-form" action="recherche_emplacement.php" method="POST" style="display: flex; align-items: center; margin-left: 20px;">
                        <input type="text" name="search" placeholder="Rechercher l'emplacement d'écran..." required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
                    </form>
        </li>
        
        <!-- Menu déroulant pour le compte utilisateur -->
        <li>
          <div class="dropdown text-center">
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #5a5af3; border-radius: 30px;">
            <img src="assets/img/user.png" alt="Avatar" class="profile-avatar" style="border-radius: 50%;  height: 40px;  object-fit: cover; margin-right: 10px;"> Mon compte
        </button>
            <!-- Options du menu déroulant -->
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">
                Profil
              </a>
              <!-- Lien de déconnexion -->
              <a class="dropdown-item" href="logout.php">
                Déconnexion
              </a>
            </div>
          </div>
        </li>
      </ul>
 
    </nav><!-- .navbar -->
  </div>
</header>


 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var champOperation = document.getElementsByName("operation")[0];
        var champNumeroLigneCms = document.getElementsByName("numero_ligne_cms")[0];
        var champEquipe = document.getElementsByName("equipe")[0];

        champOperation.addEventListener('change', function () {
            if (champOperation.value === "nettoyage") {
                champNumeroLigneCms.disabled = true;
                champNumeroLigneCms.style.opacity = "0.5";
                champEquipe.disabled = true;
                champEquipe.style.opacity = "0.5";
            } else {
                champNumeroLigneCms.disabled = false;
                champNumeroLigneCms.style.opacity = "1";
                champEquipe.disabled = false;
                champEquipe.style.opacity = "1";
            }
        });
    });
</script>

</head>
<body>

<section style="padding: 130px; height: 100vh ;width: 100%;">
<h4 class="text-center">Formulaire d'enregistrement d'utilisation d'écran de sérigraphie</h4>
<div id="erreur" style="color: red; text-align: center; padding: 12px;"></div>
    <div class="container">
        <div class="form-container mx-auto">
            <form action="enregistrer_utilisation.php" method="post" onsubmit="return validerForm()">
                <div class="form-row">
                    <div class="col">
                        <select class="form-control" name="matricule">
                            <option value="">Matricule</option>
                            <?php foreach ($matricules as $matricule) { ?>
                                <option value="<?php echo $matricule['matricule']; ?>"><?php echo $matricule['matricule']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="numero_ecran">
                            <option value="">Numéro d'écran</option>
                            <?php foreach ($ecrans as $ecran) { ?>
                                <option value="<?php echo $ecran['numero_ecran']; ?>"><?php echo $ecran['numero_ecran']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="date" placeholder="Date">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <select class="form-control" name="operation">
                            <option value="">Type d'opération</option>
                            <option value="misenprod">Mise en production</option>
                            <option value="findeprod">Fin de production</option>
                            <option value="nettoyage">Nettoyage</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="etat">
                            <option value="">État</option>
                            <option value="OK">Fonctionnel (OK)</option>
                            <option value="KO">Défectueux (KO)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <select class="form-control" name="numero_ligne_cms">
                            <option value="">Numéro de ligne CMS</option>
                            <option value="Ligne 1">Ligne 1</option>
                            <option value="Ligne 2">Ligne 2</option>
                            <option value="Ligne 3">Ligne 3</option>
                            <option value="Ligne 4">Ligne 4</option>
                            <option value="Ligne 5">Ligne 5</option>
                            <option value="Ligne 6">Ligne 6</option>
                            <option value="Ligne 7">Ligne 7</option>
                            <option value="Ligne 8">Ligne 8</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="equipe">
                            <option value="">Équipe</option>
                            <option value="MATIN">MATIN</option>
                            <option value="SOIR">SOIR</option>
                            <option value="NUIT">NUIT</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <textarea id="commentaire" name="commentaire" rows="4" cols="50" placeholder="commentaire facultatif..."></textarea>
                </div>

                <div class="form-row text-center">
                    <div class="col">
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>



<!-- Ajouter Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function validerForm() {
        var champMatricule = document.getElementsByName("matricule")[0];
        var champNumero_ecran = document.getElementsByName("numero_ecran")[0];
        var champDate = document.getElementsByName("date")[0];
        var champOperation = document.getElementsByName("operation")[0];
        var champEtat = document.getElementsByName("etat")[0];
        var champEquipe = document.getElementsByName("equipe")[0];
        var champNumero_ligne_cms = document.getElementsByName("numero_ligne_cms")[0];

        var messageErreur = document.getElementById("erreur");

        if (
            champMatricule.value.trim() === "" ||
            champDate.value.trim() === "" ||
            champOperation.value.trim() === "" ||
            champEtat.value.trim() === "" ||
            champNumero_ecran.value.trim() === ""
        ) {
            messageErreur.textContent = "Veuillez remplir les champs obligatoires.";
            return false;
        }

        if (champOperation.value.trim() !== "nettoyage") {
            if (
                champEquipe.value.trim() === "" ||
                champNumero_ligne_cms.value.trim() === ""
            ) {
                messageErreur.textContent = "Veuillez remplir les champs obligatoires.";
                return false;
            }
        }

        messageErreur.textContent = "";
        return true;
    }
</script>
</section>


<!-- Section de contact --> 
<section class="contact" id="contact" style="background-color: #eeeef5;">
    <div class="container">
        <div class="heading text-center">
            <h2>Contactez <span>Nous</span></h2>
            <p>N'hésitez pas à nous contacter si vous avez des questions supplémentaires ou des préoccupations.<br> Notre équipe est là pour vous fournir toutes les informations dont vous avez besoin.</p>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="title">
                    <h3>Coordonnées de contact</h3>
                    <p>Pour nous contacter, veuillez remplir le formulaire ci-dessous en fournissant les informations requises.</p>
                </div>
                <div class="content">
                    <!-- Info-1 -->
                    <div class="info">
                        <i class="fas fa-mobile-alt"></i>
                        <h4 class="d-inline-block">TÉLÉPHONE :<br><span>+216 57836913</span></h4>
                    </div>
                    <!-- Info-2 -->
                    <div class="info">
                        <i class="far fa-envelope"></i>
                        <h4 class="d-inline-block">EMAIL :<br><span>example@info.com</span></h4>
                    </div>
                    <!-- Info-3 -->
                    <div class="info">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4 class="d-inline-block">ADRESSE :<br><span>Zone Industrielle CHARGUIA II 2</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-7"> 
          <form action="https://formspree.io/f/mrgwznkp" method="post" onsubmit="return validerFormulaire();">
          <div class="row">
        <div class="col-sm-6">
            <input type="text" class="form-control" name="nom" placeholder="Entrez Votre Nom">
            <div id="erreur-nom" class="erreur-champ" style="color: red;"></div>
        </div>
        <div class="col-sm-6">
            <input type="email" class="form-control" name="email" placeholder="Entrez Votre Email">
            <div id="erreur-email" class="erreur-champ" style="color: red;"></div>
        </div>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="sujet" placeholder="Sujet">
            <div id="erreur-sujet" class="erreur-champ" style="color: red;"></div>
        </div>
    </div>
    <div class="form-group">
        <textarea class="form-control" rows="5" id="comment" style="resize: none;" name="message" placeholder="Message"></textarea>
        <div id="erreur-message" class="erreur-champ" style="color: red;"></div>
    </div>
<div style="display: flex; justify-content: center;">
  <button class="btn btn-block" type="submit" style="width: 750px;">Envoyer maintenant !</button>
</div>

    <script>

        function validerFormulaire() {
            var nom = document.querySelector('input[name="nom"]').value;
            var email = document.querySelector('input[name="email"]').value;
            var sujet = document.querySelector('input[name="sujet"]').value;
            var message = document.querySelector('textarea[name="message"]').value;

            var erreurs = [];

            // Réinitialiser les messages d'erreur
            document.getElementById("erreur-nom").innerHTML = "";
            document.getElementById("erreur-email").innerHTML = "";
            document.getElementById("erreur-sujet").innerHTML = "";
            document.getElementById("erreur-message").innerHTML = "";

            if (nom === "") {
                erreurs.push("Veuillez entrer votre nom.");
                document.getElementById("erreur-nom").innerHTML = '<i class="fa fa-exclamation-circle"></i> Le champ nom ne peut pas être vide.';
            }

            if (email === "") {
                erreurs.push("Veuillez entrer votre adresse e-mail.");
                document.getElementById("erreur-email").innerHTML = '<i class="fa fa-exclamation-circle"></i> Le champ email ne peut pas être vide.';
            }

            if (sujet === "") {
                erreurs.push("Veuillez entrer le sujet.");
                document.getElementById("erreur-sujet").innerHTML = '<i class="fa fa-exclamation-circle"></i> Le champ sujet ne peut pas être vide.';
            }

            if (message === "") {
                erreurs.push("Veuillez entrer votre message.");
                document.getElementById("erreur-message").innerHTML = '<i class="fa fa-exclamation-circle"></i> Le champ message ne peut pas être vide.';
            }

            if (erreurs.length > 0) {
                return false; // Empêcher l'envoi du formulaire
            }

            return true;
        }
    </script>
</form>

            </div>
        </div>
    </div>
</section>

<!-- ======= Footer ======= -->
    <footer id="footer">

<div class="footer-top">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 col-md-6 footer-contact">
      <a href="espace_utilisateur.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a><br><br>
        <p>

        cette application permet de tracer l'utilisation des écrans de sérigraphie de manière efficace. Grâce à cette application, vous pouvez enregistrer et suivre toutes les informations nécessaires concernant vos écrans de sérigraphie.
        </p>
      </div>

      <div class="col-lg-2 col-md-6 footer-links">
        <h4>Company</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Get help</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">FAQ</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">shipping</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">returns</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">order status</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-6 footer-newsletter">
      <div class="maps-container">
      <!-- Code d'intégration de la carte -->
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3192.3258467982023!2d10.208366961373189!3d36.858618614288496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12e2cb2b3d1fee4b%3A0x6f580f8f7f63fc5e!2sCIPI%20ACTIA!5e0!3m2!1sen!2stn!4v1688539577974!5m2!1sen!2stn" width="400" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
      </div>

    </div>
  </div>
</div>
</footer><!-- End Footer -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script >
const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab__content');
tabs.forEach((tab, index) => {
  tab.addEventListener('click', () => {
    tabs.forEach((t) => t.classList.remove('active-tab'));
    tabContents.forEach((content) => content.classList.remove('active-content'));
    
    tab.classList.add('active-tab');
    tabContents[index].classList.add('active-content');
  });
});
</script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>




  <!-- Scripts de Bootstrap (jQuery et Popper.js) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
