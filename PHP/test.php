<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images des Cartes</title>
    <style>
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Entrez votre numéro de sécurité sociale</h1>
    <form method="POST">
        <label for="num_secu">Numéro de Sécurité Sociale :</label>
        <input type="text" id="num_secu" name="num_secu" required>
        <button type="submit">Afficher les images</button>
    </form>

    <?php
    // Vérifie si le formulaire a été soumis
    if (isset($_POST['num_secu'])) {
        // Connexion à la base de données
        $db_username = 'slam';
        $db_password = 'sio2023';
        $db_name = 'lpfs';
        $db_host = 'localhost:3306';

        $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);

        if (!$db) {
            die('Impossible de se connecter à la base de données : ' . mysqli_connect_error());
        }

        // Récupère le numéro de sécurité sociale saisi dans le formulaire
        $num_secu = mysqli_real_escape_string($db, $_POST['num_secu']);

        // Requête pour récupérer les images
        $sql = "SELECT Carte_vit, Carte_mut, Carte_ide, Livret_fam, Carte_vital_verso, Carte_mut_verso, Carte_ide_Verso, jugement FROM documents WHERE Num_secu = '$num_secu'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<h2>Carte Vitale Recto</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_vit']) . '" alt="Carte Vitale Recto">';
                echo '<h2>Carte Vitale Verso</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_vital_verso']) . '" alt="Carte Vitale Verso">';
                echo '<h2>Carte Mutuelle Recto</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_mut']) . '" alt="Carte Mutuelle Recto">';
                echo '<h2>Carte Mutuelle Verso</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_mut_verso']) . '" alt="Carte Mutuelle Verso">';
                echo '<h2>Carte d\'Identité Recto</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_ide']) . '" alt="Carte d\'Identité Recto">';
                echo '<h2>Carte d\'Identité Verso</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Carte_ide_Verso']) . '" alt="Carte d\'Identité Verso">';
                echo '<h2>Livret de Famille</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Livret_fam']) . '" alt="Livret de Famille">';
                echo '<h2>Jugement</h2>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['jugement']) . '" alt="Jugement">';
            }
        } else {
            echo 'Aucune image trouvée pour le numéro de sécurité sociale saisi.';
        }

        // Fermeture de la connexion à la base de données
        mysqli_close($db);
    }
    ?>
</body>

</html>