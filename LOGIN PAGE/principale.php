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
    $db_password = 'root';
    $db_name = 'LPFS';
    $db_host = 'localhost:8889';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
    or die('could not connect to database');
    

    // Générer un mot de passe aléatoire
    $length = 8; // longueur du mot de passe
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($chars), 0, $length);

   // $email = $_POST['email'];
    //$destinataire = $email;
    //$sujet = "Votre mot de passe pour le site web";
    //$message = "Bonjour,\n\nVotre mot de passe pour le site web est : $password\n\nCordialement,\nL'équipe du site web";
    //$headers = "From: ugobemben@gmail.com";
    //mail($destinataire, $sujet, $message, $headers);

    // Récupérer les données soumises dans le formulaire
    if(!empty($_POST)){
      extract($_POST);

      $query="INSERT INTO `utilisateur`(`prenom`, `nom_utilisateur`, `date_de_naissance`, `poste`, `email`, `mot_de_passe`) VALUES ('$prenom','$nom','$date','$poste','$email','$password')";
      mysqli_query($db, $query);
    }
 ?>
 
 </div>
 
 <div class="mainscreen">
    <div class="card">

      <div class="leftside">
        <img src="IMG/10130-removebg-preview.png" alt="">
      </div>




    <div class="rightside">
      <form method="POST">
           <h1>Inscrire un employé(e)</h1>  

           <div class="login-box">
              <div class="prenom">
                <label for="prenom"></label>
                <div class="sec-2">
                    <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="prenom" placeholder="   Prénom"/>
                </div>
             </div>

              <div class="nom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input class="pas" type="text" name="nom" placeholder="    Nom"/>
                </div>
              </div>

              <div class="date">
                <div class="sec-2">
                 <ion-icon name="calendar-outline"></ion-icon>
                 <input type="date" name="date" placeholder="   Date de Naissance"/>
                </div>
             </div>

             <div class="poste">
                <div class="sec-2">
                 <ion-icon name="book-outline"></ion-icon>
                 <input type="text" name="poste" placeholder="  Poste"/>
                </div>
             </div>

             <div class="email">
                <label for="email"></label>
                <div class="sec-2">
                 <ion-icon name="at-circle-outline"></ion-icon>
                 <input type="email" name="email" placeholder="  Email"/>
                </div>
             </div>

              <button type="submit" class="button">Inscrire</button>
            </div>
        
      </form>
      <form method="POST" action="logout.php">
        <button type="submit" class="buttonn">Déconnexion</button>
      </form>
    </div>

  </div>

 </body>
</html>