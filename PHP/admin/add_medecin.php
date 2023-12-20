<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Ajouter un Médecin</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../../CSS/add_medecin.css" rel="stylesheet" />
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

        $sql = "SELECT * FROM personnel";
        $result = $db->query($sql);
        $sql = "SELECT * FROM services";
        $result = $db->query($sql);
        $sql = "SELECT * FROM roles";
        $result1 = $db->query($sql);

        if (!empty($_POST)) {
            extract($_POST);
            // Récupérer l'ID du service sélectionné
            $serviceIdQuery = "SELECT ID_service FROM services WHERE Nom_service = '$service'";
            $serviceIdResult = $db->query($serviceIdQuery);
            $serviceIdRow = $serviceIdResult->fetch_assoc();
            $serviceId = $serviceIdRow['ID_service'];

            // Récupérer l'ID du rôle sélectionné
            $roleIdQuery = "SELECT ID_role FROM roles WHERE Nom_role = '$metier'";
            $roleIdResult = $db->query($roleIdQuery);
            $roleIdRow = $roleIdResult->fetch_assoc();
            $roleId = $roleIdRow['ID_role'];

            // Insérer le médecin dans la table personnel avec les IDs associés
            $query = "INSERT INTO `personnel`(`Nom`, `Prénom`, `Services`, `Metier`, `mot_de_passe`, `Email`) VALUES ('$nom', '$prenom', '$serviceId', '$roleId', 'ROOT', '$email')";
            mysqli_query($db, $query);

            // Rediriger vers la page principale après avoir soumis le formulaire
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
                    <h1>Ajouter un medecin</h1>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <input type="text" name="nom" placeholder="Nom du Médecin" />
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <input type="text" name="prenom" placeholder="Prénom du Médecin" />
                        </div>
                    </div>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="service">Choisissez un service :</label>
                            <select id="service" name="service" onchange="toggleModificationSection(this.value)">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['Nom_service'] . "'>" . $row['Nom_service'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="service">Choisissez un Métier :</label>
                            <select id="service" name="metier" onchange="toggleModificationSection(this.value)">
                                <?php
                                while ($row = $result1->fetch_assoc()) {
                                    echo "<option value='" . $row['Nom_role'] . "'>" . $row['Nom_role'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <input type="text" name="email" placeholder="Email" />
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