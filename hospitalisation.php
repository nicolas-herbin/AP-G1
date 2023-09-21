<?php
session_start();
include_once "config.php";
$_SESSION["num_secu"]='10';
$num_secu=$_SESSION["num_secu"];
$query = "SELECT `Nom`, `Prénom` FROM `personnel` WHERE Metier = 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result=$stmt->fetchAll();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type =  $_REQUEST['type'];
    $date =  $_REQUEST['date'];
    $heure =  $_REQUEST['heure'];
    $medecin =  $_REQUEST['medecin'];

    $sql="INSERT INTO `hospitalisation`(`Date`, `type`, `Num_secu`, `Heure`, `Chambre`, `Docteur`) VALUES ('$date','$type','$num_secu','$heure','1','$medecin')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    
<form  action="" method=post enctype='multipart/form-data'>
    <label for="">pre-admission pour:</label><br>
    <select name="type" id="type_pre">
        <option value="">Choix</option>
        <option value="chirurgie">Ambulatoire chirurgie</option>
        <option value="hospitalisation">Hospitalisation (au moins une nuit)</option>
    </select>
    <label for="Prix">Date</label><br>
    <input type="date" id="date" name="date" value=""><br>
    <label for="heure">Heure de l'intervention</label><br>
    <input type="time" id="heure" name="heure" value="heure"><br><br>
    <label for="">Choix medecin</label><br>
    <select name="medecin" id="medecin">
        <option value="">Choix</option>
        <?php 
            foreach ($result as $result){
                ?>
                <option value="<?php echo$result['Nom']?>"><?php echo$result['Nom']?> </option> 
                <?php
            }
        
        ?>
    </select>
    <input type="submit" value="Submit">
  </form>
</body>
</html>