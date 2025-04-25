<?php
// Démarrer la session si nécessaire
session_start();

// Inclure la page demandée
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Vérifier si le fichier existe dans app/
if (file_exists("app/$page.php")) {
    require "app/views/$page.php";
} else {
    echo "Erreur 404 : Page non trouvée";
}
?>
