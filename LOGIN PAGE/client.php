<html>
<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link href="client.css" rel="stylesheet" />
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

    // Requête SQL pour récupérer les données des patients
    $sql = "SELECT * FROM patient";
    $result = $db->query($sql);

    if(!empty($_POST)){
        extract($_POST);
        $query = "INSERT INTO `patient`(`Num_secu`, `Civ`, `Nom_naissance`, `Nom_ep`, `Prenom`, `Adresse`, `Cp`, `Ville`, `Email`, `Telephone`) VALUES ('$num_secu','$civ','$nom_naissance','$nom_ep','$prenom','$adresse','$cp','$ville','$email','$telephone')";
        mysqli_query($db, $query);
        $_SESSION['num_secu']=$num_secu ; 
        // Rediriger vers infoclient.php après avoir soumis le formulaire
        echo '<script>window.location.href = "infoclient.php";</script>';
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
                <h1>Inscrire un Patient</h1>
                <div class="nom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="num_secu" placeholder="Numero de sécurité social"/>
                </div>
              </div>

              <div class="prenom">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="civ" placeholder="Votre civilisation"/>
                </div>
              </div>

             <div class="email">
                <label for="email"></label>
                <div class="sec-2">
                 <ion-icon name="at-circle-outline"></ion-icon>
                 <input type="text" name="nom_naissance" placeholder="Votre Nom de Naissance"/>
                </div>
             </div>

             <div class="sexe">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="nom_ep" placeholder="Votre Nom épouse"/>
                </div>
              </div>

             <div class="social">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="prenom" placeholder="  Prenom"/>
                </div>
              </div>

              <div class="telephone">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="adresse" placeholder="Votre Adresse"/>
                </div>
              </div>

              <div class="medicaux">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="cp" placeholder="Votre code postale"/>
                </div>
              </div>

              <div class="probleme">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="ville" placeholder="Votre ville"/>
                </div>
              </div>

              <div class="medicaux">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="email" name="email" placeholder="Votre email"/>
                </div>
              </div>

              <div class="medicaux">
               <div class="sec-2">
                <ion-icon name="accessibility-outline"></ion-icon>
                 <input type="text" name="telephone" placeholder="Votre Numéro de téléphone"/>
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
