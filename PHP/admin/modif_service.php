<html>

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link href="../../CSS/modif_service.css" rel="stylesheet" />
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
        include_once('connexion.php');

        if (!empty($_POST)) {
            // Vérifier si le formulaire est soumis
            $serviceToModify = $_POST['service'];
            $newServiceName = $_POST['new_service_name'];

            // Mettre à jour le nom du service dans la base de données
            $query = "UPDATE services SET Nom_service = '$newServiceName' WHERE Nom_service = '$serviceToModify'";
            mysqli_query($db, $query);

            // Rediriger vers la page principale après modification
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
                    <h1>Modifier un Service</h1>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="service">Choisissez un service à modifier:</label>
                            <select id="service" name="service" onchange="toggleModificationSection(this.value)">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['Nom_service'] . "'>" . $row['Nom_service'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Section de modification (initiallement masquée) -->
                    <div id="modificationSection">

                        <div class="prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" id="new_service_name" name="new_service_name"
                                    placeholder="Nouveau nom du service:" />
                            </div>
                        </div>

                        <button type="submit" class="button">Appliquer la modification</button>
                    </div>
                </form>
                <button class="button" onclick="window.location.href='../redirection.php'">Pre admission</button>
            </div>
        </div>
    </div>

    <script>
        function toggleModificationSection(selectedService) {
            // Récupérer l'élément de la section de modification
            var modificationSection = document.getElementById("modificationSection");

            // Afficher la section de modification si un service est sélectionné, sinon la masquer
            modificationSection.style.display = selectedService ? "block" : "none";
        }
    </script>

</body>

</html>