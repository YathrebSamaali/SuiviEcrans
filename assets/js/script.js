// veroifier enregistrement d'utilisation
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
// Ce script JavaScript est conçu pour écouter l'événement "DOMContentLoaded", ce qui signifie qu'il s'exécutera une fois que le contenu de la page aura été complètement chargé. Il cible trois éléments spécifiques du formulaire en fonction de leurs noms, à savoir "operation", "numero_ligne_cms" et "equipe".
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

//verification pour l'authentification si non erreur
function validerForm() {
    // Récupérer les éléments du formulaire
    var champNom = document.getElementsByName("username")[0];
    var champMotDePasse = document.getElementsByName("matricule")[0];

    var messageErreur = document.getElementById("erreur");

    // Vérifier si les champs sont vides
    if (champNom.value.trim() === "" || champMotDePasse.value.trim() === "" ) {
        // Afficher un message d'erreur et empêcher la soumission
        messageErreur.innerHTML = "Veuillez remplir tous les champs.";
        return false;
    } else {
        // Réinitialiser le message d'erreur
        messageErreur.innerHTML = "";

        // Vérifier si un message d'erreur PHP est présent
        var errorMessageFromPHP = "<?php echo $errorMessage; ?>";
        if (errorMessageFromPHP !== "") {
            // Afficher le message d'erreur PHP et empêcher la soumission
            messageErreur.innerHTML = errorMessageFromPHP;
            return false;
        }

        // Tous les champs sont remplis et pas d'erreur PHP, permettre la soumission
        return true;
    }
}

//losque clic sur recherche soummettre 
function handleKeyPress(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("search-form").submit();
    }
}

//formulaire de contact
function validerFormulaire() {
    var nom = document.querySelector('input[name="nom"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var sujet = document.querySelector('input[name="sujet"]').value;
    var message = document.querySelector('textarea[name="message"]').value;

    var erreurs = [];

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

