<?php
################################Log a la basse de donnée##########################################################



//don't change
    //$databases_acces = 'http://192.168.20.85/';
    //$databases_port = '3306';
//connection BDD locale
    //$databases_names1 = 'LPFS';
    //$databases_pass1 = 'sio2023';
    //$databases_user1 = 'slam';


//don't change
    $databases_acces = 'localhost';
    $databases_port = '3306';
//connection BDD locale
    $databases_names1 = 'lpfs';
    $databases_pass1 = '';
    $databases_user1 = 'root';

//requet et test de connection a la bdd
try{
    $pdo = new PDO("mysql:host=$databases_acces;dbname=$databases_names1;charset_utf8;","$databases_user1", "$databases_pass1");
    }
    catch (PDOException $exc){
    echo $exc->getMessage();
    exit();
    }
    
?>

