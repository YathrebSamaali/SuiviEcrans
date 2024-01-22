<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['matricule'])  && isset($_POST['email']) && isset($_POST['telephone']) && isset($_POST['adresse'])) {
        $username = $_POST['username'];
        $matricule = $_POST['matricule'];

        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];

        try {
            // Connexion à la base de données PostgreSQL
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT * FROM suiviecrans.users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                echo "L'utilisateur existe déjà.";
            } else {
                // Insérer l'utilisateur dans la table "users"
                $insertStmt = $pdo->prepare("INSERT INTO suiviecrans.users (username, matricule, email, telephone, adresse) VALUES (:username, :matricule, :email, :telephone, :adresse)");
                $insertStmt->bindParam(':username', $username);
                $insertStmt->bindParam(':matricule', $matricule);
                $insertStmt->bindParam(':email', $email);
                $insertStmt->bindParam(':telephone', $telephone);
                $insertStmt->bindParam(':adresse', $adresse);
                $insertStmt->execute();

                echo "L'utilisateur a été enregistré avec succès.";

                // Redirection vers la page de connexion
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Formulaire d'inscription</title>

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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/styleContact.css" rel="stylesheet">

  <!--js-->
  <script src="assets/js/script.js"></script>

  <!--font answone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-**********" crossorigin="anonymous" />

   <!-- custom css file link  -->
   <link href="assets/css/style.css" rel="stylesheet">


</head>
<body>
 
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>

      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php" style="margin-top:20px;">Accueil</a></li>
          
          
       
          <li><a class="nav-link scrollto" href="#contact" style="margin-top:20px;">Contact</a></li>
          <li>
                    <!-- Formulaire de recherche -->
                    <form id="search-form" action="recherche_emplacement.php" method="POST" style="display: flex; align-items: center; margin-left: 20px;">
                        <input type="text" name="search" placeholder="Rechercher l'emplacement d'écran..." required onkeydown="handleKeyPress(event)" style="padding: 8px; border: 1px solid #ccc; border-radius: 24px;width: 300px;">
                    </form>
                </li>
          <li><a class="getstarted scrollto" href="index.php">Se connecter</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 order-1 order-lg-2 hero-form">
                <form method="post" action="" onsubmit="return validerForm()">
                    <h2 class="text-center">S'inscrire</h2>
                    <div id="erreur" style="color: red; text-align: center; padding: 12px;"></div>
                   
                    
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur">
                    </div>
                    <div class="form-group">
                        <input type="text" name="matricule" class="form-control" placeholder="Matricule">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail">
                    </div>
                    <div class="form-group row">
                    <div class="col-md-6">
    <input type="text" name="telephone" class="form-control" placeholder="N°Téléphone" >
</div>

                        <div class="col-md-6">
                            <input type="text" name="adresse" class="form-control" placeholder="Adresse">
                        </div>
                    </div>
                   
                   
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="S'inscrire">
                    </div>
                    <p class="text-center my-3">Avez-vous un compte ? <a href="index.php" id="login-btn">Connectez-vous</a></p>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
 function validerForm() {
    var champNom = document.getElementsByName("username")[0];
    var champMatricule = document.getElementsByName("matricule")[0];
    var champEmail = document.getElementsByName("email")[0];
    var champTelephone = document.getElementsByName("telephone")[0];
    var champAdresse = document.getElementsByName("adresse")[0];
    var messageErreur = document.getElementById("erreur");

    if (
        champNom.value.trim() === "" ||
        champMatricule.value.trim() === "" ||
        champEmail.value.trim() === "" ||
        champTelephone.value.trim() === "" ||
        champAdresse.value.trim() === "" 
     
    ) {
        messageErreur.textContent = "Veuillez remplir tous les champs.";
        return false;
    }

    if (champMatricule.value.trim().length !== 4 || !/^[0-9a-zA-Z]+$/.test(champMatricule.value.trim())) {
        messageErreur.textContent = "Le matricule doit être composé de 4 caractères alphanumériques.";
        return false;
    }

    if (!/\S+@\S+\.\S+/.test(champEmail.value.trim())) {
        messageErreur.textContent = "Veuillez saisir une adresse e-mail valide (par exemple, exemple@gmail.com).";
        return false;
    }

    if (!/^[0-9]{8}$/.test(champTelephone.value.trim())) {
        messageErreur.textContent = "Veuillez entrer un numéro de téléphone valide composé de 8 chiffres.";
        return false;
    }

    messageErreur.textContent = "";
    return true;
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
 
  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

        <div class="col-lg-3 col-md-6 footer-contact">
          <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a><br><br>
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

</body>
</html>