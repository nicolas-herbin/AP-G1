<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Ajouter un service</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../../CSS/add_service.css" rel="stylesheet" />
</head>

<body>
    <div id="content">
        <!-- tester si l'utilisateur est connecté -->
        <?php
        session_start();
        if (!isset($_SESSION['username']) || $_SESSION['username'] === null || $_SESSION['username'] == '') {
            header('location:../index.php');
        }
        ;
        if ($_SESSION['username'] !== "") {
            $user = $_SESSION['username'];
        }
        // connexion à la base de données
        $db_username = 'slam';
        $db_password = 'sio2023';
        $db_name = 'lpfs';
        $db_host = 'localhost:3306';

        $db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
            or die('could not connect to database');

        $sql = "SELECT * FROM services";
        $result = $db->query($sql);
        if (!empty($_POST)) {
            extract($_POST);
            $query = "INSERT INTO `services`(`Nom_service`) VALUES ('$Nom_service')";
            mysqli_query($db, $query);
            // Rediriger vers infoclient.php après avoir soumis le formulaire
            header('location:../admin.php');
            exit(); // Assure que la redirection se produit immédiatement
        }
        ?>

    </div>
    <div class="mainscreen">
        <div class="card">
            <div class="leftside">
                <img src="../../IMG/4990224-removebg-preview.png" alt="">
            </div>
            <div class="rightside">
                <form method="POST">
                    <h1>Ajouter un service</h1>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <input type="text" name="Nom_service" placeholder="Nommé Le Service" />
                        </div>
                    </div>


                    <button type="submit" class="button">Ajouter</button>
                </form>
                <button class="button" onclick="window.location.href='../redirection.php'">Pre admission</button>
            </div>
        </div>
    </div>
</body>

</html>