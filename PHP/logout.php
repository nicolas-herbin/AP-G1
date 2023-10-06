<?php
session_start(); // ouverture de la session
session_unset(); // suppression des variables de session
session_destroy(); // destruction de la session
header("Location: login.php"); // redirection vers la page de connexion
exit(); // arrêt du script
?>