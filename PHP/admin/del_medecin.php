<html>

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link href="../../CSS/del_medecin.css" rel="stylesheet" />
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
        // Connexion à la base de données
        include_once('../connexion.php');

        if (!empty($_POST)) {
            // Vérifier si le formulaire est soumis
            $serviceToDelete = $_POST['personnel'];

            // Supprimer le service de la base de données
            $query = "DELETE FROM personnel WHERE Nom = '$serviceToDelete'";
            mysqli_query($db, $query);
            $query = "SELECT count(*) FROM personnel WHERE Nom = '$serviceToDelete'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($result);
            $count = $row['count(*)'];
            if ($count = 0) {
                // Rediriger vers la page principale après suppression
                header('Location: ../admin.php');
                exit();
            } else {
                echo "ERREUR";
            }
        }

        // Récupérer les services de la base de données
        $sql = "SELECT * FROM personnel";
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
                    <h1>Supprimer un membre du personnel</h1>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="service">Choisissez un membre du personnel à supprimer:</label>
                            <select id="service" name="personnel">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['Nom'] . "'>" . $row['Nom'] . "</option>";
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