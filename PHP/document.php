<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document LPFS</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../CSS/document.css" rel="stylesheet" />
</head>

<body>
    <div id="content">
        <!-- Tester si l'utilisateur est connecté -->
        <?php
        session_start();
        if (!isset ($_SESSION['username']) || $_SESSION['username'] === null || $_SESSION['username'] == '') {
            header('location:../index.php');
        }
        ;

        // Connexion à la base de données
        include_once ('connexion.php');
        // Requête SQL pour récupérer les données des patients
        $sql = "SELECT * FROM couverture_social";
        $result = $db->query($sql);

        if (!empty ($_POST)) {
            extract($_POST);
            $num_secu = $_SESSION['num_secu'];

            // Gestion de l'image
            if (isset ($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_tmp = $_FILES['image']['tmp_name'];
                $image_content = file_get_contents($image_tmp);
                $image_content = mysqli_real_escape_string($db, $image_content);
            } else {
                // Gérez le cas où aucune image n'a été téléchargée ou une erreur s'est produite
                // Peut-être afficher un message d'erreur à l'utilisateur
            }

            // Traitez chaque fichier
            $carteVitaleData = file_get_contents($_FILES['carte_vitale_recto']['tmp_name']); // Recto
            $carteVitaleVersoData = file_get_contents($_FILES['carte_vitale_verso']['tmp_name']); // Verso
            $carteMutuelleData = file_get_contents($_FILES['carte_mutuelle_recto']['tmp_name']); // Recto
            $carteMutuelleVersoData = file_get_contents($_FILES['carte_mutuelle_verso']['tmp_name']); // Verso
            $carteIdentiteData = file_get_contents($_FILES['carte_identite_recto']['tmp_name']); // Recto
            $carteIdentiteVersoData = file_get_contents($_FILES['carte_identite_verso']['tmp_name']); // Verso
            $livretFamilleData = file_get_contents($_FILES['livret_famille_recto']['tmp_name']); // Recto
            $jugementRectoData = file_get_contents($_FILES['jugement_recto']['tmp_name']); // Recto
        
            // Échappez les données pour les requêtes SQL
            $carteVitaleData = mysqli_real_escape_string($db, $carteVitaleData);
            $carteVitaleVersoData = mysqli_real_escape_string($db, $carteVitaleVersoData);
            $carteMutuelleData = mysqli_real_escape_string($db, $carteMutuelleData);
            $carteMutuelleVersoData = mysqli_real_escape_string($db, $carteMutuelleVersoData);
            $carteIdentiteData = mysqli_real_escape_string($db, $carteIdentiteData);
            $carteIdentiteVersoData = mysqli_real_escape_string($db, $carteIdentiteVersoData);
            $livretFamilleData = mysqli_real_escape_string($db, $livretFamilleData);
            $jugementRectoData = mysqli_real_escape_string($db, $jugementRectoData);

            // Insérez les données dans la table documents avec les images
            $query = "INSERT INTO `documents`(`Carte_vit`, `Carte_mut`, `Carte_ide`, `Livret_fam`, `Num_secu`, `Carte_vital_verso`, `Carte_mut_verso`, `Carte_ide_Verso`, `Jugement`) 
                  VALUES ('$carteVitaleData', '$carteMutuelleData', '$carteIdentiteData', '$livretFamilleData', '$num_secu', '$carteVitaleVersoData', '$carteMutuelleVersoData', '$carteIdentiteVersoData', '$jugementRectoData')";
            mysqli_query($db, $query);

            // Rediriger vers hospitalisation.php après avoir soumis le formulaire
            echo '<script>window.location.href = "PDFgen.php";</script>';
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
                <form method="POST" enctype="multipart/form-data">
                    <h1>Documents à fournir :</h1>

                    <div class="nom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <input type="text" name="num_secu" placeholder="<?php echo $_SESSION['num_secu'] ?>"
                                readonly />
                        </div>
                    </div>


                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="carte_vitale_recto">Carte Vitale (Recto/Verso) :</label>
                            <input type="file" name="carte_vitale_recto" id="carte_vitale_recto"
                                accept=".jpg, .jpeg, .png, .pdf" />
                            <input type="file" name="carte_vitale_verso" id="carte_vitale_verso"
                                accept=".jpg, .jpeg, .png, .pdf" />
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="carte_mutuelle_recto">Carte Mutuelle (Recto/Verso) :</label>
                            <input type="file" name="carte_mutuelle_recto" id="carte_mutuelle_recto"
                                accept=".jpg, .jpeg, .png, .pdf" />
                            <input type="file" name="carte_mutuelle_verso" id="carte_mutuelle_verso"
                                accept=".jpg, .jpeg, .png, .pdf" />
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="carte_identite_recto">Carte d'Identité (Recto/Verso) :</label>
                            <input type="file" name="carte_identite_recto" id="carte_identite_recto"
                                accept=".jpg, .jpeg, .png, .pdf" />
                            <input type="file" name="carte_identite_verso" id="carte_identite_verso"
                                accept=".jpg, .jpeg, .png, .pdf" />
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="livret_famille_recto">Livret de Famille (Recto) :</label>
                            <input type="file" name="livret_famille_recto" id="livret_famille_recto"
                                accept=".jpg, .jpeg, .png, .pdf" />
                        </div>
                    </div>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="jugement_recto">Jugement (Recto) :</label>
                            <input type="file" name="jugement_recto" id="jugement_recto"
                                accept=".jpg, .jpeg, .png, .pdf" />
                        </div>
                    </div>

                    <!-- Répétez le même schéma pour d'autres types de cartes si nécessaire -->

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