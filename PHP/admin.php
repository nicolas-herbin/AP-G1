<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Panel Administrateur</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
  <link href="../CSS/admin.css" rel="stylesheet" />
</head>
 <body>
 <div id="content">
    <!-- tester si l'utilisateur est connecté -->
    <?php
session_start();
if($_SESSION['username'] !== ""){
    $user = $_SESSION['username'];
}
// connexion à la base de données
$db_username = 'slam';
    $db_password = 'sio2023';
    $db_name = 'lpfs';
    $db_host = 'localhost:3306';

$db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
    or die('could not connect to database');

// Requête SQL pour récupérer les données des patients
$sql = "SELECT * FROM couverture_social";
$result = $db->query($sql);

if(!empty($_POST)){
    extract($_POST);
    $num_secu=$_SESSION['num_secu'] ; 
    // Convertir les valeurs "oui" et "non" en 1 et 0
    $assure_value = ($assure === "oui") ? 1 : 0;
    $ald_value = ($ald === "oui") ? 1 : 0;

    $query = "INSERT INTO `couverture_social`(`Num_secu`, `Assure`, `ALD`, `Nom_secu`, `Nom_mutuelle`, `Num_adherent`) VALUES ('$num_secu','$assure_value','$ald_value','$nom_secu','$nom_mutuelle','$num_adherent')";
    mysqli_query($db, $query);

    // Rediriger vers hospitalisation.php après avoir soumis le formulaire
    echo '<script>window.location.href = "hospitalisation.php";</script>';
    exit(); // Assure que la redirection se produit immédiatement
}
?>

</div>
<div class="mainscreen">
    <div class="card">
        <div class="leftside">
            <img src="../IMG/4990224-removebg-preview.png" alt="">
        </div>
        <div class="rightside">
                <h1>Action Administrateur</h1>

                <p class="Service"> Service : </p>

                <button  class="button" onclick="window.location.href='admin/add_service.php'">Ajouter </button>
                <button  class="button" onclick="window.location.href='admin/del_service.php'">Modifier </button>
                <button  class="button" onclick="window.location.href='admin/modif_service.php'">Supprimer </button>


                <p class="Service"> Médecin : </p>

                <button class="button">Ajouter </button>
                <button class="button">Modifier </button>
                <button class="button">Supprimer </button>


                <p class="Service"> Pré Admission : </p>

                <button class="button" onclick="window.location.href='client.php'">Ajouter </button>
                <button class="button" onclick="window.location.href='admin/modif_pre.php'">Modifier </button>
                <button class="button" onclick="window.location.href='admin/del_pre.php'">Supprimer </button>
        </div>
    </div>
</div>
 </body>
</html>