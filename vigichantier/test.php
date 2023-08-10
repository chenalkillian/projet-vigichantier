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
$sql = "SELECT DATE_FORMAT(date_heure, '%Y-%m-%d %H:%i') AS date_formatted, 
               MAX(CASE WHEN type = 1 THEN valeur END) AS temperature, 
               MAX(CASE WHEN type = 2 THEN valeur END) AS humidite, 
               MAX(CASE WHEN type = 3 THEN valeur END) AS pression 
        FROM mesure 
        GROUP BY date_formatted 
        ORDER BY date_formatted";
$result = $conn->query($sql);

// Organiser les données en tableaux pour le graphe
$labels = array();
$data_temperature = array();
$data_humidite = array();
$data_pression = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    array_push($labels, $row["date_formatted"]); // Ajout de la date à l'étiquette
    array_push($data_temperature, $row["temperature"]);
    array_push($data_humidite, $row["humidite"]);
    array_push($data_pression, $row["pression"]);
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

<h1>Informations sur l'environnement</h1>

  <canvas id="myChart"></canvas>
  <script>
    // Créer le graphique
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // Type de graphique
        type: 'line',

        // Données à afficher
        // Données à afficher
data: {
  labels: <?php echo json_encode($labels); ?>,
  datasets: [{
    label: 'température',
    data: <?php echo json_encode($data_temperature); ?>,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 2
  }, {
    label: 'humidité',
    data: <?php echo json_encode($data_humidite); ?>,
    backgroundColor: 'rgba(54, 162, 235, 0.2)',
    borderColor: 'rgba(54, 162, 235, 1)',
    borderWidth: 2
  }, {
    label: 'pression',
    data: <?php echo json_encode($data_pression); ?>,
    backgroundColor: 'rgba(50, 206, 86, 0.2)',
    borderColor: 'rgba(255, 206, 86, 1)',
    borderWidth: 2
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
