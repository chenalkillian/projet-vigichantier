<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si la requête est de type POST

    $username = $_POST['identifiant'];
    $password = $_POST['motdepasse'];
    // Récupérer les valeurs des champs de saisie "identifiant" et "motdepasse"

    // Déclaration des paramètres
    $identifiant = "killian";
    $motdePASSE = "azerty77!";

    if ($identifiant == $username && $motdePASSE === $password) {
        // Vérifier si l'identifiant et le mot de passe correspondent

        header("Location: pageAcceuil.html");
        // Redirection vers la page "pageAcceuil.html"
        exit();
        // Terminer l'exécution du script
    } else {
        echo '<div class="loginBox">
              <form><img class="user" src="https://www.aproposdecriture.com/wp-content/uploads/2013/08/erreur.gif" height="100px" width="100px"><p>Votre identifiant ou mot de passe est incorrect </form>';
        // Afficher un message d'erreur si l'identifiant ou le mot de passe est incorrect

        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title>Erreur</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  </body>
</html>
