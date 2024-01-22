<?php
require_once '../config.php';

// Connexion à la base de données PostgreSQL
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Récupération du nombre d'écrans
$result_ecrans = pg_query($conn, "SELECT COUNT(*) FROM suiviecrans.ecrans");
$nombre_ecrans = pg_fetch_result($result_ecrans, 0, 0);

// Récupération du nombre d'utilisateurs inscrits
$result_users = pg_query($conn, "SELECT COUNT(*) FROM suiviecrans.users");
$nombre_users = pg_fetch_result($result_users, 0, 0);

// Récupération de l'état des écrans
$result_etat_ecrans = pg_query($conn, "SELECT etat, COUNT(*) FROM suiviecrans.utilisation GROUP BY etat");

// Génération du graphique
$graph_data = array();
while ($row = pg_fetch_assoc($result_etat_ecrans)) {
    $graph_data[$row['etat']] = $row['count'];
}
 
// Récupération des données pour l'axe des ordonnées (nombre d'écrans par mois)
$result_usage = pg_query($conn, "SELECT date_trunc('month', date) AS mois, COUNT(DISTINCT numero_ecran) AS count FROM suiviecrans.utilisation GROUP BY date_trunc('month', date) ORDER BY EXTRACT(MONTH FROM date_trunc('month', date))");

// Génération des données pour le graphique
$usage_data = array();
while ($row = pg_fetch_assoc($result_usage)) {
    $usage_data[$row['mois']] = intval($row['count']); // Conversion en entier
}

// Fermeture de la connexion
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administrateur</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <link rel="stylesheet" href="../assets/css/styleContact.css"> <!-- Lien vers votre fichier CSS personnalisé -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Favicons -->
<link href="../assets/img/icon.png" rel="icon" >
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       

    </style>
</head>
<body style=" position:fixed">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="espace_admin.php" style="display: flex; justify-content: center;">
            <img src="../assets/img/logo.png" width="220" height="50" class="d-inline-block align-top" alt="">
    
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            <ul class="navbar-nav ml-auto" style="margin-top: 10px;">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid p-0">
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
        <h1 class="h2">Tableau de bord</h1>
    </div>

    <div class="row">
    <div class="col-lg-4">
    <div class="card text-white" style="background-color: #5a5af3; margin-bottom: 15px;">
        <div class="card-body">
            <h4 class="card-title" style="font-size: 18px;"><i class="fas fa-sort-numeric-up"></i> Nombre des écrans de sérigraphie</h4>
            <p class="card-text" style="font-size: 28px; font-weight: bold;"><?php echo $nombre_ecrans; ?></p>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card text-white" style="background-color: #5a5af3; margin-bottom: 15px;">
        <div class="card-body">
            <h4 class="card-title" style="font-size: 18px;"><i class="fas fa-users"></i> Nombre des utilisateurs inscrits</h4>
            <p class="card-text" style="font-size: 28px; font-weight: bold;"><?php echo $nombre_users; ?></p>
        </div>
    </div>
</div>


        <div style="width: 800px; height: 400px; padding-left: 20px; ">
            <canvas id="lineChart"></canvas>
        </div>
        <div style="width: 400px; height: 400px; margin-left: 20px;">
        <canvas id="myChart"></canvas>
        
    </div>
   
    </div>

    

    <script>
        var graph_data = <?php echo json_encode($graph_data); ?>;
        var labels = Object.keys(graph_data);
        var values = Object.values(graph_data);

        var ctx = document.getElementById('myChart').getContext('2d');

        var count_ok = values[labels.indexOf('OK')] || 0;
        var count_ko = values[labels.indexOf('KO')] || 0;

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombres ',
                    data: values,
                    backgroundColor: [
                        '#FE0000', // rouge pour "KO"
                        '#28DF99', // vert pour "OK"
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: `État des écrans - En bon état(Ok): ${count_ok}, Défectueux(KO): ${count_ko} -`
                        
                    }
                }
            }
        });
    </script>


<script>
            var usageData = <?php echo json_encode($usage_data); ?>;
            var months = Object.keys(usageData);
            var usageValues = Object.values(usageData);

            var ctx2 = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: months.map(month => new Date(month).toLocaleString('default', { month: 'long' })), // Formater les mois
                    datasets: [{
                        label: 'Nombre d\'écrans',
                        data: usageValues,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre d\'écrans utilisés par mois',
                            fontSize: 20
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            }
                        }
                    }
                }
            });
        </script>
</main>

        </div>
    </div>

    <!-- JavaScript requis pour les fonctionnalités Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
