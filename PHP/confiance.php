<?php
session_start();
include_once "config.php";
$ID_personne = $_SESSION['ID_personne'];
$num_secu = $_SESSION["num_secu"];
$sql = "SELECT personne.ID_personne, personne.nom ,personne.prenom, personne.telephone from personne inner join personne_prev on personne.ID_personne = personne_prev.ID_personne and personne.ID_personne=$ID_personne";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["form1"])) {
        // Form 1 was submitted
        $sql = "INSERT INTO `personne_conf`(`ID_personne`, `Num_secu`) VALUES ('$ID_personne','$num_secu')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } elseif (isset($_POST["form2"])) {
        // Form 2 was submitted
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $telephone = $_REQUEST['telephone'];
        $adresse = $_REQUEST['adresse'];

        $sql = "INSERT INTO `personne`(`Nom`, `Prenom`, `Telephone`, `Adresse`) VALUES ('$nom','$prenom','$telephone','$adresse')";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $sql = "SELECT * FROM `personne` WHERE `Telephone`='$telephone'";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                $ID_personne = $result[0][0];
                $sql = "INSERT INTO `personne_conf`(`ID_personne`, `Num_secu`) VALUES ('$ID_personne','$num_secu')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $_SESSION['ID_personne'] = $ID_personne;
            }
        }
    }
    header('location:document.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personne Confiance</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../CSS/confiance.css" rel="stylesheet" />
</head>

<body>
    <div class="mainscreen">
        <div class="card">
            <div class="leftside">
                <img src="../IMG/4990224-removebg-preview.png" alt="">
            </div>
            <div class="rightside">
                <form method="POST">
                    <h1>Coordonnées personne de confiance</h1>

                    <div class="nom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <select name="medecin" id="medecin" onchange="myFunction()">
                                <option value="">utilisé precendente personne ?</option>
                                <?php
                                foreach ($result as $result) {
                                    ?>
                                    <option value="<?php echo $result['ID_personne'] ?>">
                                        <?php echo $result['nom'] . ' ' . $result['prenom'] ?>
                                    </option>
                                    <?php
                                }

                                ?>
                                <option value="autre">utilisé Autre personne ?</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="form1" id="1erbutton" class="button">Suivant </button>
                </form>


                <!-- Function to show the div myDIV when autre is selected -->
                <script> function myFunction() {
                        var x = document.getElementById("myDIV");
                        var y = document.getElementById("1erbutton");
                        var select = document.getElementById("medecin");
                        if (select.value === "autre") {
                            if (x.style.display === "none") {
                                x.style.display = "block";
                                y.style.display = "none";
                            } else {
                                x.style.display = "none";
                                y.style.display = "block";
                            }
                        }
                    }
                </script>




                <div id="myDIV" style="display: none;">


                    <form method="POST">
                        <div class="nom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" name="num_secu" placeholder="<?php echo $_SESSION['num_secu'] ?>"
                                    readonly />
                            </div>
                        </div>


                        <div class="nom">
                            <label for="nom"></label>
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="nom" id="nom" name="nom" placeholder="Nom" value="">
                            </div>
                        </div>

                        <div class="prenom">
                            <label for="prenom"></label>
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="prenom" id="prenom" name="prenom" placeholder="prenom" value="">
                            </div>
                        </div>

                        <div class="nom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" maxlength='10' name="telephone" placeholder="numéro telephone" />
                            </div>
                        </div>

                        <div class="nom">
                            <div class="sec-2">
                                <ion-icon name="accessibility-outline"></ion-icon>
                                <input type="text" name="adresse" placeholder="Votre Adresse" />
                            </div>
                        </div>
                        <button type="submit" name="form2" class="button">Suivant ></button>
                    </form>

                    <form method="POST" action="logout.php">
                        <button type="submit" class="buttonn">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>