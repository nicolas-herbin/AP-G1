<html>

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link href="../../CSS/del_service.css" rel="stylesheet" />
    <script type="text/javascript" src="../JS_client.js"></script>
    <title>Supprimer Un Service </title>
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

        $db = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die('could not connect to database');

        if (!empty($_POST)) {
            // Vérifier si le formulaire est soumis
            $serviceToDelete = $_POST['service'];

            // Supprimer le service de la base de données
            $query = "DELETE FROM services WHERE Nom_service = '$serviceToDelete'";
            mysqli_query($db, $query);

            // Rediriger vers la page principale après suppression
            header('Location: ../admin.php');
            exit();
        }

        // Récupérer les services de la base de données
        $sql = "SELECT * FROM services";
        $result = $db->query($sql);
        ?>
    </div>

    <div class="mainscreen">
        <div class="card">
            <div class="leftside">
                <img src="../../IMG/4990224-removebg-preview.png" alt="">
            </div>
            <div class="rightside">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- Ajout de l'action et méthode POST -->
                    <h1>Supprimer un Service</h1>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="service">Choisissez un service à supprimer:</label>
                            <select id="service" name="service">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['Nom_service'] . "'>" . $row['Nom_service'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="button">Supprimer ></button>
                </form>
                <button class="button" onclick="window.location.href='../redirection.php'">Pre admission</button>
            </div>
        </div>
    </div>

</body>

</html>