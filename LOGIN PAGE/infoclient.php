<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>LOGIN PAGE LPF</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
  <link href="principale.css" rel="stylesheet" />
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
$db_username = 'root';
      $db_password = '';
      $db_name = 'LPFS';
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

    // Rediriger vers infoclient.php après avoir soumis le formulaire
    echo '<script>window.location.href = "../hospitalisation.php";</script>';
    exit(); // Assure que la redirection se produit immédiatement
}
?>

</div>
<div class="mainscreen">
    <div class="card">
        <div class="leftside">
            <img src="IMG/4990224-removebg-preview.png" alt="">
        </div>
        <div class="rightside">
            <form method="POST">
                <h1>Information sur le Patient</h1>
                
                <div class="nom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="num_secu" placeholder="<?php echo $_SESSION['num_secu'] ?>"readonly/>
                </div>
              </div>

            <div class="email">
                <label for="email">Le patient est-il assuré ?</label>
                <div class="sec-2">
                    <input type="radio" name="assure" value="oui" id="assure-oui">
                    <label for="assure-oui">Oui</label>
                    <input type="radio" name="assure" value="non" id="assure-non">
                    <label for="assure-non">Non</label>
                </div>
            </div>

            <div class="email">
                <label for="email">Le patient est-il en ALD ?</label>
                <div class="sec-2">
                    <input type="radio" name="ald" value="oui" id="ald-oui">
                    <label for="ald-oui">Oui</label>
                    <input type="radio" name="ald" value="non" id="ald-non">
                    <label for="ald-non">Non</label>
                </div>
            </div>

            <div class="prenom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="nom_secu" placeholder="Nom de la caisse d'assurance maladie"/>
                </div>
              </div>

             <div class="prenom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="nom_mutuelle" placeholder="Nom de la mutuelle"/>
                </div>
              </div>

              <div class="prenom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="num_adherent" placeholder="Numero adhérent"/>
                </div>
              </div>

                <button type="submit" class="button">Suivant ></button>
            </form>

            <form method="POST" action="logout.php">
                <button type="submit" class="buttonn">Déconnexion</button>
            </form>
        </div>
    </div>
</div>
 </body>
</html>