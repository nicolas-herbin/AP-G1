<?php
include_once("config.php");
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] === null || $_SESSION['username'] == '') {
    header('location:../index.php');
}
;
$ID_doc = $_SESSION['ID_doc'];

$sql = "SELECT p.Nom,h.Date,h.Heure,h.type,pa.Nom_naissance,pa.Telephone FROM personnel p 
INNER JOIN hospitalisation h on p.ID = h.Docteur
INNER JOIN patient pa on h.Num_secu = pa.Num_secu
WHERE p.ID=$ID_doc 
AND DATEDIFF(CURDATE(), h.Date) < 30
ORDER BY h.Date,h.Heure;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_rdv = $stmt->fetchAll();
//var_dump($result_rdv);
$ResultRdvNom = $result_rdv[0]['Nom'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Page MÃ©decin</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../CSS/modif_medecin.css" rel="stylesheet" />
</head>

<body>
    <div id="content">
    </div>

    <div class="mainscreen">
        <div class="card">
            <div class="leftside">
                <img src="../IMG/4990224-removebg-preview.png" alt="">
            </div>
            <div class="rightside">
                <form method="POST">
                    <div id="modificationSection" style="display:block;">

                        <?php echo "<h1>Bonjour Docteur $ResultRdvNom </h1>" ?>

                        <div class=" prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <label for="service">Voici vos prochain rdv :</label>

                                <?php
                                foreach ($result_rdv as $result_rdv) {

                                    echo "<p> $result_rdv[Date]" . ' ' . "$result_rdv[Heure]" . ' ' . "$result_rdv[type]" . ' ' . "$result_rdv[Nom_naissance]" . ' ' . "$result_rdv[Telephone]  </p>";
                                }
                                ?>

                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>