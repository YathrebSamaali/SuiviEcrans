# **Application de Traçabilité des Écrans de Sérigraphie**

Une application informatique pour tracer l'utilisation des écrans de sérigraphie et gérer leurs états dans un environnement CMS. Cette solution est conçue pour améliorer la gestion, la qualité et la traçabilité des processus industriels.

---

## **Table des matières**
1. [Description](#description)
2. [Fonctionnalités principales](#fonctionnalités-principales)
3. [Pré-requis](#pré-requis)
4. [Installation et configuration](#installation-et-configuration)
5. [Utilisation](#utilisation)
6. [Structure des fichiers](#structure-des-fichiers)
7. [Auteur](#auteur)

---

## **Description**
Cette application permet aux opérateurs et administrateurs de suivre les états des écrans de sérigraphie pendant les différentes phases de production et de nettoyage, avec des options de recherche et d'exportation d'historique.

---

## **Fonctionnalités principales**
1. **Gestion des écrans** :
   - Ajout et suppression d'écrans par les administrateurs.
   - Consultation des écrans existants avec leurs informations.

2. **Suivi des états** :
   - Saisie des états des écrans (OK/KO) pour les opérations :
     - Mise en production.
     - Fin de production.
     - Nettoyage avant et après.

3. **Recherche et historique** :
   - Recherche des écrans par :
     - Numéro d’écran.
     - Référence produit.
     - Période.
     - Face.
   - Exportation de l’historique d'utilisation.

4. **Espaces dédiés** :
   - Espace utilisateur pour les opérateurs.
   - Espace administrateur pour la gestion et le suivi.

---

## **Pré-requis**
Avant de commencer, assurez-vous d'avoir les éléments suivants installés et configurés sur votre machine :  

1. **Environnement de développement** :
   - [PHP](https://www.php.net/downloads) (version 7.4 ou supérieure).
   - [Apache](https://httpd.apache.org/) ou tout autre serveur compatible.
   - [PostgreSQL](https://www.postgresql.org/download/) (version 12 ou supérieure).
   - [DBeaver](https://dbeaver.io/download/) pour gérer la base de données (ou tout autre outil de votre choix).

2. **Outils recommandés** :
   - [XAMPP](https://www.apachefriends.org/index.html) ou [WAMP](http://www.wampserver.com/) pour configurer un environnement local.
   - Un éditeur de code comme [Visual Studio Code](https://code.visualstudio.com/) ou [PHPStorm](https://www.jetbrains.com/phpstorm/).

3. **Outils de gestion de version** :
   - [Git](https://git-scm.com/) pour cloner et gérer le dépôt du projet.

4. **Navigateur web** :
   - Un navigateur moderne compatible avec les applications web (Chrome, Firefox, Edge, etc.).

5. **Extension PHP** :
   - Vérifiez que les extensions suivantes sont activées dans votre fichier `php.ini` :
     ```ini
     extension=pdo_pgsql
     extension=pdo
     ```

---

## **Installation et configuration**
1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/YathrebSamaali/SuiviEcrans.git
