<?php
include_once "../config.php";

// ini 
$sql = "SELECT * FROM personnel p inner join roles r on p.Metier=r.ID_role inner join services s on p.Services=s.ID_service order by Nom asc";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_personnel = $stmt->fetchAll();

$sql = "SELECT * FROM roles order by Nom_role asc";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_role = $stmt->fetchAll();

$sql = "SELECT * FROM services order by Nom_service asc";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_service = $stmt->fetchAll();
if (isset($_POST["form1"])) {
    // ini 
    $GLOBALS['IDmed'] = $_REQUEST['selectedMedecin'];
    $IDmed = $GLOBALS['IDmed'];
    $sql = "SELECT * FROM personnel p inner join roles r on p.Metier=r.ID_role inner join services s on p.Services=s.ID_service where `ID`=$IDmed order by Nom asc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
} elseif (isset($_POST["form2"])) {
    // ini 
    $nom = $_REQUEST['nom'];
    $service = $_REQUEST['service'];
    $prenom = $_REQUEST['prenom'];
    $metier = $_REQUEST['metier'];
    $email = $_REQUEST['email'];
    $IDmed = $GLOBALS['IDmed'];

    $sql = "UPDATE `personnel` SET `Nom`='$nom',`Prénom`='$prenom',`Services`='$service',`Metier`='$metier',`Email`='$email' where ID=$IDmed";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Modifier un Médecin</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../../CSS/modif_medecin.css" rel="stylesheet" />
</head>

<body>
    <div id="content">
    </div>

    <div class="mainscreen">
        <div class="card">
            <div class="leftside">
                <img src="../../IMG/4990224-removebg-preview.png" alt="">
            </div>
            <div class="rightside">
                <form method="POST">
                    <h1>Modifier un médecin</h1>

                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <label for="medecin">Choisissez un Médecin :</label>
                            <select id="medecin" name="selectedMedecin">
                                <?php
                                foreach ($result_personnel as $result_personnel) {
                                    ?>
                                    <option value="<?php echo $result_personnel['ID'] ?>">
                                        <?php echo $result_personnel['Nom'] ?>
                                    </option>
                                    <?php
                                }


                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="submit" name="form1" value="suivant" class="button">
                </form>
                <form method="POST">
                    <div id="modificationSection" style="display:block;">
                        <div class="prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" name="nom" placeholder="Nom du Médecin"
                                    value="<?php echo $result[0]['Nom'] ?>" />
                            </div>
                        </div>

                        <div class="prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" name="prenom" placeholder="Prénom du Médecin"
                                    value="<?php echo $result[0]['Prénom'] ?>" />
                            </div>
                        </div>

                        <div class=" prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <label for="service">Choisissez un service :</label>
                                <select id="service" name="service">
                                    <?php
                                    foreach ($result_service as $result_service) {
                                        $is_selected = ($result[0]['Services'] === $result_service["ID_service"]) ? ' selected' : '';
                                        echo "<option value={$result_service['ID_service']}{$is_selected}>  {$result_service['Nom_service']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <label for="metier">Choisissez un Métier :</label>
                                <select id="metier" name="metier">
                                    <?php
                                    foreach ($result_role as $result_role) {
                                        $is_selected = ($result[0]['Metier'] === $result_role["ID_role"]) ? ' selected' : '';
                                        var_dump($is_selected);
                                        echo "<option value={$result_role['ID_role']}{$is_selected}>  {$result_role['Nom_role']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="prenom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" name="email" value="<?php echo $result[0]['Email'] ?>">
                            </div>
                        </div>
                        <input type="submit" name="form2" value="suivant" class="button">

                    </div>
                </form>
                <button class="button" onclick="window.location.href='../redirection.php'">Pre admission</button>
            </div>
        </div>
    </div>


</body>

</html>