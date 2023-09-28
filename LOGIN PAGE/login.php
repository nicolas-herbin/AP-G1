<?php
            // Start a session if not already started
            session_start();

            // Function to generate a random CAPTCHA string
            function generateRandomCaptcha($length = 6) {
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                $captcha = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomIndex = mt_rand(0, strlen($characters) - 1);
                    $captcha .= $characters[$randomIndex];
                }
                return $captcha;
            }

            // Generate and store the server-generated CAPTCHA in a session variable
            $serverGeneratedCaptcha = generateRandomCaptcha(6);
            $_SESSION['captcha'] = $serverGeneratedCaptcha;
            ?>

<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>LOGIN PAGE LPF</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
  <link href="../CSS/login.css" rel="stylesheet" />
</head>

<body>
  <div class="mainscreen">
    <div class="card">

      <div class="leftside">
        <img src="IMG/10130-removebg-preview copie.png" alt="">
      </div>




    <div class="rightside">
      <form action="verification.php" method="POST">
            <h1>Se Connecter</h1> 
           <div class="login-box">
              <div class="email">
                <label for="email"></label>
                <div class="sec-2">
                  <ion-icon name="at-circle-outline"></ion-icon>
                 <input type="email" name="username" placeholder="    Email"/>
                </div>
             </div>
              <div class="password">
               <label for="password"></label>
               <div class="sec-2">
                 <ion-icon name="lock-closed-outline"></ion-icon>
                 <input class="pas" type="password" name="password" placeholder="    Votre Mot De Passe"/>
                </div>
              </div>
              <input type="hidden" name="serverCaptcha" value="<?php echo $serverGeneratedCaptcha; ?>">
            <!-- End server-generated CAPTCHA -->

            <!-- Text-based CAPTCHA -->
            <div class="captcha-box">
                <label for="captcha">Recopiez le texte suivant:</label>
                <p id="generatedCaptcha"></p>
                <input type="text" id="captchaInput" name="captchaInput" placeholder="Votre réponse" required />
                <button type="button" onclick="generateCaptcha()">Générer un nouveau</button>
            </div>

            <button type="submit" id='connec' class="button">Connexion</button>
            </div>
        
      </form>
      <script>
      // Function to display the generated CAPTCHA
      function generateCaptcha() {
          const captcha = document.querySelector('input[name="serverCaptcha"]').value;
          document.getElementById('generatedCaptcha').textContent = captcha;
          document.getElementById('captchaInput').value = '';
      }

      // Generate a CAPTCHA when the page loads
      window.onload = function() {
          generateCaptcha();
      };
    </script>
    </div>

  </div>

</body>
</html>
