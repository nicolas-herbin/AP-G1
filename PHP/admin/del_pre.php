<?php
session_start();
include_once "../config.php";
$sql="SELECT * FROM patient";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result=$stmt->fetchAll();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todel =  $_REQUEST['todel'];

    $sql="DELETE FROM personne_prev WHERE Num_secu=$todel;
    DELETE FROM personne_conf WHERE Num_secu=$todel;
    DELETE FROM documents WHERE Num_secu=$todel;
    DELETE FROM hospitalisation WHERE Num_secu=$todel;
    DELETE FROM couverture_social WHERE Num_secu=$todel;
    DELETE FROM patient WHERE Num_secu=$todel;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();}
?>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Panel Administrateur</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
  <link href="../../CSS/del_pre.css" rel="stylesheet" />
</head>
<body>
<div id="content">

</div>
<div class="mainscreen">
    <div class="card">
        <div class="leftside">
            <img src="../../IMG/4990224-removebg-preview.png" alt="">
        </div>
        <div class="rightside">
            <form method="POST">
                <h1>Choisir le patient a delete</h1>
                    
                <div class="nom">
                    <div class="sec-2">
                        <ion-icon name="accessibility-outline"></ion-icon>
                        <select name="todel" id="type_pre">
                        <?php 
                                        foreach ($result as $result){
                                            ?>
                                            <option value="<?php echo $result['Num_secu'] ?>"><?php echo "Nom naissance : ".$result['Nom_naissance']." Nom ep : ".$result['Nom_ep']." Prenom : ".$result['Prenom']." Num sécu : ".$result['Num_secu']?> </option> 
                                            <?php
                                        }
                                    
                                    ?>
                        </select>
                    </div>
                </div>
                
                    <button type="submit" class="button">Supprimer</button>
            </form>
        </div>
    </div>
</div>
 </body>
</html>