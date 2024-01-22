<?php
// Démarrer la session pour utiliser les variables de session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["loggedin"])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page d'index (peut-être une page de connexion) et arrêter l'exécution du script.
    header("location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espace utilisateur</title>
  
  <!-- CSS de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <!--font answone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-**********" crossorigin="anonymous" />
  <!-- Favicons -->
  <link href="assets/img/icon.png" rel="icon" >
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/styleContact.css" rel="stylesheet">

  <!--js-->
  <script src="assets/js/script.js"></script>
  
  <script>
        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("search-form").submit();
            }
        }
  </script>

</head>
<body>
<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center justify-content-between">
    <!-- Logo -->
    <a href="espace_utilisateur.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
    <!-- Navigation -->
    <nav id="navbar" class="navbar">
      <ul>
        <!-- Lien vers la page d'accueil -->
        <li><a class="nav-link scrollto active" href="espace_utilisateur.php" style="margin-top:20px;font-weight: normal;">Accueil</a></li>
        
        <!-- Lien vers la page d'opérations -->
        <li><a class="nav-link scrollto" href="utilisation.php" style="margin-top:20px;font-weight: normal;">Enregistrer une utilisation</a></li>
        
        <!-- Lien vers la section de contact -->
        <li><a class="nav-link scrollto" href="#contact" style="margin-top:20px; font-weight: normal;">Contact</a></li>
        
        <!-- Champ de recherche -->
        <li class="mr-3">
          <form id="search-form" action="recherche_emplacement.php" method="POST" style="display: flex; align-items: center; margin-left: 20px;">
              <input type="text" name="search" placeholder="Rechercher l'emplacement d'écran..." required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
          </form>
        </li>
        
        <!-- Dropdown pour le compte utilisateur -->
        <li>
          <div class="dropdown text-center">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #5a5af3; border-radius: 30px;">
                  <img src="assets/img/user.png" alt="Avatar" class="profile-avatar" style="border-radius: 50%;  height: 40px;  object-fit: cover; margin-right: 10px;"> Mon compte
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- Lien vers le profil utilisateur -->
                  <a class="dropdown-item" href="#">Profil</a>
                  <!-- Lien de déconnexion -->
                  <a class="dropdown-item" href="logout.php">Déconnexion</a>
              </div>
          </div>
        </li>

      </ul>
      
    </nav><!-- .navbar -->
  </div>
</header>

<!-- Section Hero -->
<section id="hero" class="d-flex align-items-center">
  <div class="container">
    <div class="row">
      <!-- Colonne pour le contenu textuel -->
      <div class="col-lg-6 pt-2 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
        <!-- Titre principal -->
        <h1>Traçabilité de l'utilisation des écrans de sérigraphie</h1>
        <ul>
          <!-- Listes des fonctionnalités -->
          <li><i class="ri-check-line"></i>Permettre aux opérateurs de saisir les informations à l'utilisation des écrans.</li>
          <li><i class="ri-check-line"></i>Permettre la recherche de l'emplacement des écrans de sérigraphie.</li>
          <li><i class="ri-check-line"></i>Permettre l'extraction de l'historique d'utilisation des écrans.</li>
        </ul>
        <!-- Bouton de contact -->
        <div class="mt-3">
          <a href="#contact" class="btn-get-started scrollto">Contactez-Nous</a>
        </div>
      </div>
      <!-- Colonne pour l'image ou la vidéo -->
      <div class="col-lg-6 order-1 order-lg-2 hero-img">
        <!-- Balise vidéo avec contrôles -->
        <div class="video-container">
        <div class="video-cover">
        <img src="assets/img/image.PNG" alt="Couverture de la vidéo" style="width:100%;">
        <button class="play-button" onclick="playVideo()"><img src="assets/img/play.png" class="play-icon" alt="Play"></button>
    </div>

    <video id="myVideo" class="img-fluid" style="display:none; width:100%;" controls>
        <!-- Source de la vidéo -->
        <source src="assets/video/intro1.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge la vidéo.
    </video>
</div>
      </div>
    </div>
  </div>
</section>
<!--ce script pour lire le video -->
<script>
    function playVideo() {
        var video = document.getElementById("myVideo");
        var videoCover = document.querySelector('.video-cover');
        video.style.display = "block";
        video.play();
        videoCover.style.display = "none";
    }
</script>

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


</main><!-- End #main -->



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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
