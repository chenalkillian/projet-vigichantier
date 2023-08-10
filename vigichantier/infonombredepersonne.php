<?php
// Connexion à la base de données
$servername = "localhost";
$username = "kiki";
$password = "azerty77";
$dbname = "vigichantier";

$conn = new mysqli($servername, $username, $password, $dbname);

header("refresh:120"); // rafraîchissement de la page après 5 secondes


// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données de la table
$sql = "SELECT nbpersonne, DATE_FORMAT(date, '%Y-%m-%d %H:%i') AS date_formatted FROM tagrfid ORDER BY date";
$result = $conn->query($sql);

// Organiser les données en tableaux pour le graphe
$labels = array();
$data = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    array_push($labels, $row["date_formatted"]);
    array_push($data, $row["nbpersonne"]);
  }
}


// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Données</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1> Historique des présences :</h1></h1>

  <canvas id="myChart"></canvas>
  <script>
    // Créer le graphique
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // Type de graphique
        type: 'bar',

        // Données à afficher
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Nombre de personnes',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },

        // Options de configuration du graphique
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
  </script>
</body>
</html>

 
