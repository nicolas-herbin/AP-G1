<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name = 'LPFS';
    $db_host = 'localhost:3306';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
    or die('could not connect to database');
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    
    if($username !== "" && $password !== "" && $_POST['captchaInput']==$_SESSION['captcha'])
    {
        $requete = "SELECT Metier FROM personnel where 
        email = '".$username."' and mot_de_passe = '".$password."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $id = $reponse['Metier'];
        
        if(mysqli_num_rows($exec_requete) > 0 && $id == 4) // id d'utilisateur est 0
        {
            $_SESSION['username'] = $username;
            header('Location: client.php');
        }
        else if(mysqli_num_rows($exec_requete) > 0 && $id == 1) // id d'utilisateur est 1
        {
            $_SESSION['username'] = $username;
            header('Location: index.html');
        }
        else // id d'utilisateur incorrect
        {
            header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
        header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
    header('Location: login.php');
}

mysqli_close($db); // fermer la connexion
?>