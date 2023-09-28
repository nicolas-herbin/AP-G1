<?php
// Informations de connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'LPFS';
$db_host = 'localhost:3306';

// Établir la connexion à la base de données
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die('Could not connect to database');

// Votre code pour changer le mot de passe va ici...

?>
