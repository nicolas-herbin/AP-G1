<?php
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Connexion à la base de données
    include_once('connexion.php');

    // Échapper les données pour éviter les attaques SQL
    $username = mysqli_real_escape_string($db, htmlspecialchars($_POST['username']));
    $password = mysqli_real_escape_string($db, htmlspecialchars($_POST['password']));

    if ($username !== "" && $_POST['captchaInput'] == $_SESSION['captcha']) {
        // Vérifier si le mot de passe est "root"
        if (strtolower($password) === 'root') {
            // Mot de passe est "root", vérifier si l'utilisateur existe
            $check_user_query = "SELECT * FROM personnel WHERE Email = '$username'";
            $user_result = mysqli_query($db, $check_user_query);

            if (mysqli_num_rows($user_result) > 0) {
                // L'utilisateur existe, rediriger vers create_password.php
                $_SESSION['username'] = $username;
                header('Location: create_password.php');
                exit();
            }
        }

        // Effectuer la requête SQL pour vérifier l'utilisateur
        $requete = "SELECT Metier,ID FROM personnel WHERE Email = '" . $username . "' AND mot_de_passe = '" . $password . "'";
        $exec_requete = mysqli_query($db, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $metier = $reponse['Metier'];
        $ID_doc = $reponse['ID'];
        if (mysqli_num_rows($exec_requete) > 0 && $metier == 4) {
            // Utilisateur trouvé avec le mot de passe correct, rediriger vers la page client
            $_SESSION['username'] = $username;
            $_SESSION['ID_doc'] = $ID_doc;
            header('Location: redirection.php');
            exit();
        } else if (mysqli_num_rows($exec_requete) > 0 && $metier == 1) {
            // Utilisateur trouvé avec le mot de passe correct, rediriger vers la page index.html
            $_SESSION['username'] = $username;
            $_SESSION['ID_doc'] = $ID_doc;
            header('Location: docteur.php');
            exit();
        } else if (mysqli_num_rows($exec_requete) > 0 && $metier == 3) {
            // Utilisateur trouvé avec le mot de passe correct, rediriger vers la page index.html
            $_SESSION['username'] = $username;
            $_SESSION['ID_doc'] = $ID_doc;
            header('Location: client.php');
            exit();
        } else {
            // Mot de passe incorrect pour l'utilisateur
            header('Location: ../index.php?erreur=1');
            exit();
        }
    } else {
        // Utilisateur vide
        header('Location: ../index.php?erreur=2');
        exit();
    }
} else {
    // Rediriger vers la page de connexion si les données POST ne sont pas définies
    header('Location: ../index.php');
    exit();
}


?>