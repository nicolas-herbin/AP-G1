<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}

if (isset($_POST['new_password'])) {
    // Connexion à la base de données
    $db_username = 'slam';
    $db_password = 'sio2023';
    $db_name = 'lpfs';
    $db_host = 'localhost:3306';
    
    
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die('Could not connect to the database');

    // Échapper les données pour éviter les attaques SQL
    $new_password = mysqli_real_escape_string($db, htmlspecialchars($_POST['new_password']));

    // Vérifier si le mot de passe respecte les normes
    $is_valid_password =
        strlen($new_password) >= 16 &&          // Au moins 16 caractères
        preg_match('/[A-Z]/', $new_password) && // Au moins une majuscule
        preg_match('/[a-z]/', $new_password) && // Au moins une minuscule
        preg_match('/[0-9]/', $new_password) && // Au moins un chiffre
        preg_match('/[A-Za-z0-9]/', $new_password); // Au moins un caractère alphanumérique

    if ($is_valid_password) {
        // Récupérer le nom d'utilisateur de la session
        $username = $_SESSION['username'];

        // Mettre à jour le mot de passe de l'utilisateur connecté
        $update_query = "UPDATE personnel SET mot_de_passe = '$new_password' WHERE Email = '$username'";
        mysqli_query($db, $update_query);

        // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
        header('Location: ../index.php'); // Changez 'index.html' en la page que vous souhaitez après la mise à jour du mot de passe
        exit();
    } else {
        // Le nouveau mot de passe ne respecte pas les normes, vous pouvez gérer cette situation comme vous le souhaitez
        // Par exemple, affichez un message d'erreur ou redirigez l'utilisateur vers une autre page
        header('Location: create_password.php?erreur=2');
        exit();
    }

    mysqli_close($db); // Fermer la connexion à la base de données
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../CSS/create_password.css" rel="stylesheet" />
    <title>Création de mot de passe</title>
</head>
<body>

<div class="mainscreen">
    <div class="card">

      <div class="leftside">
        <img src="../IMG/10130-removebg-preview copie.png" alt="">
      </div>




    <div class="rightside">
      <form action="create_password.php" method="post">
           <h1 class="espace">Création de votre mot de passe :</h1>
            <?php if (isset($_GET['erreur']) && $_GET['erreur'] == 2): ?>
            <p>Le nouveau mot de passe ne respecte pas les normes.</p>
            <?php endif; ?> 
            <div class="login-box">

            <div class="password">
               <label for="password"></label>
               <div class="sec-2">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <label for="new_password">Nouveau mot de passe : </label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
              </div>
    <ul class="conditions-list">
        <li>Vous devez avoir 16 caractères.</li>
        <li>Au moins une majuscule.</li>
        <li>Au moins une minuscule.</li>
        <li>Au moins un chiffre.</li>
        <li>Au moins un caractère alphanumérique.</li>
    </ul>
    <span id="password-message" class="password-invalid">Vous ne respecter pas toutes les conditions.</span>
    <?php if (isset($_GET['erreur']) && $_GET['erreur'] == 2): ?>
        <p class="error-message">Vous respecter toutes les conditions.</p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success-message">Mot de passe mis à jour avec succès.</p>
    <?php endif; ?>
    <button type="submit" id="update-button" class="button-espace">Mettre à jour le mot de passe</button>
</div>
        
      </form>
    </div>

  </div>

    <script>
        // Sélectionnez le champ de mot de passe
        const newPasswordInput = document.getElementById('new_password');
        const passwordMessage = document.getElementById('password-message');
        const updateButton = document.getElementById('update-button');

        // Fonction pour vérifier si toutes les conditions sont remplies
        function checkConditions(password) {
            const isValid =
                password.length >= 16 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[A-Za-z0-9]/.test(password);

            if (isValid) {
                passwordMessage.textContent = 'Vous respecter toutes les conditions.';
                passwordMessage.classList.remove('password-invalid');
                passwordMessage.classList.add('password-valid');
                updateButton.style.display = 'block'; // Afficher le bouton de mise à jour
            } else {
                passwordMessage.textContent = 'Vous ne respecter pas toutes les conditions.';
                passwordMessage.classList.remove('password-valid');
                passwordMessage.classList.add('password-invalid');
                updateButton.style.display = 'none'; // Masquer le bouton de mise à jour
            }
        }

        // Ajoutez un gestionnaire d'événement d'entrée pour vérifier les conditions en temps réel
        newPasswordInput.addEventListener('input', function () {
            const password = newPasswordInput.value;
            checkConditions(password);
        });
    </script>
</body>
</html>


