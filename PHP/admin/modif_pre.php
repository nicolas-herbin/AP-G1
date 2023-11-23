<?php
session_start();
$table = '';
$num_secu = '';
include_once "../config.php";
$sql = "SELECT * FROM patient";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
// SELECT to get info about doctor 
$sql = "SELECT Nom,Prénom,ID FROM personnel where Metier=1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_docteur = $stmt->fetchAll();
// SELECT to get the chamber's name 
$sql = "SELECT * FROM chambre";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_chambre = $stmt->fetchAll();
if (isset($_POST["form1"])) {
    $GLOBALS['table'] = $_REQUEST['table'];
    $GLOBALS['num_secu'] = $_REQUEST['num_secu'];
} elseif (isset($_POST["form2"])) {
    //Change the request based on which table is changed
    $table = $_REQUEST['table'];

    //=================================================================================HOSPITALISATION=================================================================================== 
    if ($table === "hospitalisation") {
        echo 'entre hospi';
        //ini
        $num_secu = $_REQUEST['num_secu'];
        $type = $_REQUEST['type'];
        $date = $_REQUEST['date'];
        $heure = $_REQUEST['heure'];
        $chambre = $_REQUEST['chambre'];
        $docteur = $_REQUEST['docteur'];
        //prep
        $sql = "UPDATE `hospitalisation` SET `Date`='$date',`type`='$type',`Heure`='$heure',`Chambre`='$chambre',`Docteur`='$docteur' WHERE Num_secu=$num_secu;";

    }
    //=================================================================================DOCUMENTS======================================================================================== 
    elseif ($table === "documents") {
        // CETTE CHOSE NE FONCTIONNE PAS J'EN AI MARRE 
        //ini
        $carte_vitaler = file_get_contents($_FILES['carte_vitale_recto']['tmp_name']);
        $carte_vitalev = file_get_contents($_FILES['carte_vitale_verso']['tmp_name']);
        $carte_mutueller = file_get_contents($_FILES['carte_mutuelle_recto']['tmp_name']);
        $carte_mutuellev = file_get_contents($_FILES['carte_mutuelle_verso']['tmp_name']);
        $carte_idr = file_get_contents($_FILES['carte_identite_recto']['tmp_name']);
        $carte_idv = file_get_contents($_FILES['carte_identite_verso']['tmp_name']);
        $livret_fam = file_get_contents($_FILES['livret_famille_recto']['tmp_name']);
        $jugement = file_get_contents($_FILES['jugement_recto']['tmp_name']);
        $num_secu = $_REQUEST['num_secu'];

        //prep
        $sql = "UPDATE `documents` SET `Carte_vit`=$carte_vitaler, `Carte_mut`=$carte_mutueller, `Carte_ide`=$carte_idr, `Livret_fam`=$livret_fam,  `Carte_vital_verso`=$carte_vitalev, `Carte_mut_verso`=$carte_mutuellev, `Carte_ide_Verso`=$carte_idv, `jugement`=$jugement WHERE Num_secu=$num_secu";


    }

    //=================================================================================PATIENT========================================================================================== 
    elseif ($table === "patient") {
        echo 'entre pat';
        //ini
        $nom_naissance = $_REQUEST['nom_naissance'];
        $nom_epouse = $_REQUEST['nom_epouse'];
        $prenom = $_REQUEST['prenom'];
        $adresse = $_REQUEST['adresse'];
        $cp = $_REQUEST['cp'];
        $ville = $_REQUEST['ville'];
        $email = $_REQUEST['email'];
        $telephone = $_REQUEST['telephone'];
        $date_naissance = $_REQUEST['date_naissance'];
        $num_secu = $_REQUEST['num_secu'];
        //prep
        $sql = "UPDATE `patient` SET `Nom_naissance`='$nom_naissance',`Nom_ep`='$nom_epouse',
        `Prenom`='$prenom',`Adresse`='$adresse',`Cp`='$cp',`Ville`='$ville',`Email`='$email',`Telephone`='$telephone',`Date_naissance`='$date_naissance' WHERE `Num_secu`=$num_secu";

    }
    //=================================================================================COUVERTURE=======================================================================================        
    elseif ($table === "couverture_social") {
        echo 'entre couv';
        $num_secu = $_REQUEST['num_secu'];
        $assure = $_REQUEST['assure'];
        $ALD = $_REQUEST['ALD'];
        $nom_secu = $_REQUEST['nom_mutuelle'];
        $num_adh = $_REQUEST['num_adherent'];
        $nom_adh = $_request['nom_adherent'];


        //prep
        $sql = "UPDATE `couverture_social` SET `Assure`='$assure',`ALD`='$ALD',`Nom_secu`='$nom_secu',`Nom_mutuelle`='$nom_adh',`Num_adherent`='$num_adh' WHERE Num_secu=$num_secu";

    }
    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    //header("location:../admin.php");
}
?>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Panel Administrateur</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://ibb.co/XYBMjYG">
    <link href="../../CSS/del_pre.css" rel="stylesheet" />
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
                    <div class="prenom">
                        <div class="sec-2">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            <select name="table" id="type_pre">
                                <!-- IMPORTANT | TO CHANGE : need to make a table with the name of the other table in case we add a new one so it can automatically update-->
                                <option value="hospitalisation">hospitalisation </option>
                                <option value="documents">documents </option>
                                <option value="patient">patient </option>
                                <option value="couverture_social">couverture social </option>
                            </select>
                        </div>
                    </div>
                    <select name="num_secu" id="type_pre">
                        <?php
                        foreach ($result as $result) {
                            ?>
                            <option value="<?php echo $result['Num_secu'] ?>">
                                <?php echo "Nom naissance : " . $result['Nom_naissance'] . " Nom ep : " . $result['Nom_ep'] . " Prenom : " . $result['Prenom'] . " Num sécu : " . $result['Num_secu'] ?>
                            </option>
                            <?php
                        }

                        ?>
                    </select>
                    <input type="submit" name="form1" value="suivant" class="button"></button>
                </form>

                <?php
                $table = $GLOBALS['table'];
                $num_secu = $GLOBALS['num_secu'];
                //FORM 2
//----------------------------------------------------------------------------HOSPITALISATION------------------------------------------------------------------------------------
                if ($table === "hospitalisation") {
                    $sql = "SELECT hospitalisation.*,personnel.ID,personnel.Nom FROM hospitalisation inner join personnel on hospitalisation.Docteur=personnel.ID WHERE hospitalisation.Num_secu=$num_secu";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result2 = $stmt->fetchAll();

                    echo ' <form method="POST">';
                    echo ' <div class="prenom">';
                    echo ' <div class="sec-2">';
                    echo ' <ion-icon name="accessibility-outline"></ion-icon>';

                    //affichage type , select auto from DB 
                    echo ' <select name="type" id="type_pre" required>';
                    $is_type_selected = ($result2[0]["type"] == "chirurgie") ? ' selected' : '';
                    $is_not_type_selected = ($result2[0]["type"] == "hospitalisation") ? ' selected' : '';
                    echo "<option value='chirurgie'{$is_type_selected}>chirurgie</option>";
                    echo "<option value='hospitalisation'{$is_not_type_selected}>hospitalisation</option>";
                    echo '  </select>';

                    //affichage date & heure
                    echo '  <input type="date"  name="date" value="' . $result2[0]['Date'] . '">';
                    echo '  <input type="time"  name="heure" value="' . $result2[0]['Heure'] . '">';

                    //affichage chambre , auto select the one in the DB 
                    echo "  <select name='chambre'>";
                    foreach ($result_chambre as $result_chambre) {
                        $is_selected = ($result_chambre["ID_chambre"] === $result2[0]['Chambre']) ? ' selected' : '';
                        echo "<option value={$result_chambre['ID_chambre']}{$is_selected}> Type : {$result_chambre['Type_chambre']}</option>";
                    }
                    ;
                    echo '  </select>';

                    //affichage docteur 
                    echo "  <select name='docteur'>";
                    foreach ($result_docteur as $result_docteur) {
                        var_dump($result_docteur);
                        echo " <option value=$result_docteur[ID]> Nom docteur : $result_docteur[Nom]</option>";

                    }
                    ;
                    echo '  </select>';
                    echo " <input type='hidden' name='table' value=$table>";
                    echo " <input type='hidden' name='num_secu' value=$num_secu>";
                    echo '  <input type="submit" name="form2" value="suivant" class="button"></button>';
                    echo '</form>';
                }
                //----------------------------------------------------------------------------DOCS------------------------------------------------------------------------------------
                elseif ($table === "documents") {
                    $sql = "SELECT * FROM documents WHERE Num_secu=$num_secu ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result2 = $stmt->fetchAll();
                    echo ' <form method="POST" enctype="multipart/form-data>';
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_vit']) . '" /> ';
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_vital_verso']) . '" /> ';
                    echo '<div class="prenom">';
                    echo '        <div class="sec-2">';
                    echo '            <ion-icon name="accessibility-outline"></ion-icon>';
                    echo '            <label for="carte_vitale_recto">Carte Vitale (Recto/Verso) :</label>';
                    echo '            <input type="file" name="carte_vitale_recto" id="carte_vitale_recto" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '            <input type="file" name="carte_vitale_verso" id="carte_vitale_verso" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '        </div>';
                    echo '</div>';
                    //===================================================================================================================================================================
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_mut']) . '" /> ';
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_mut_verso']) . '" /> ';
                    echo '<div class="prenom">';
                    echo '        <div class="sec-2">';
                    echo '            <ion-icon name="accessibility-outline"></ion-icon>';
                    echo '            <label for="carte_mutuelle_recto">Carte Vitale (Recto/Verso) :</label>';
                    echo '            <input type="file" name="carte_mutuelle_recto" id="carte_mutuelle_recto" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '            <input type="file" name="carte_mutuelle_verso" id="carte_mutuelle_verso" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '        </div>';
                    echo '</div>';
                    //===================================================================================================================================================================
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_ide']) . '" /> ';
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Carte_ide_Verso']) . '" /> ';
                    echo '<div class="prenom">';
                    echo '        <div class="sec-2">';
                    echo '            <ion-icon name="accessibility-outline"></ion-icon>';
                    echo '            <label for="carte_identite_recto">Carte Identite (Recto/Verso) :</label>';
                    echo '            <input type="file" name="carte_identite_recto" id="carte_identite_recto" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '            <input type="file" name="carte_identite_verso" id="carte_identite_verso" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '        </div>';
                    echo '</div>';
                    //==================================================================================================================================================================
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['Livret_fam']) . '" /> ';
                    echo '<img class="product-image" src="data:image/jpeg;base64,' . base64_encode($result2[0]['jugement']) . '" /> ';
                    echo '<div class="prenom">';
                    echo '        <div class="sec-2">';
                    echo '            <ion-icon name="accessibility-outline"></ion-icon>';
                    echo '            <label for="carte_vitale_recto"> jugemeent , livret fam :</label>';
                    echo '            <input type="file" name="livret_famille_recto" id="livret_famille_recto" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '            <input type="file" name="jugement_recto" id="jugement_recto" accept=".jpg, .jpeg, .png, .pdf" />';
                    echo '        </div>';
                    echo '</div>';
                    echo " <input type='hidden' name='table' value=$table>";
                    echo " <input type='hidden' name='num_secu' value=$num_secu>";
                    echo '  <input type="submit" name="form2" value="suivant" class="button"></button>';
                } //Carte_vit	Carte_mut	Carte_ide	Livret_fam	Num_secu	Carte_vital_verso	Carte_mut_verso	Carte_ide_Verso	jugement	
                

                //------------------------------------------------------------------------------------------PATIENT------------------------------------------------------------------------------------ 
                elseif ($table === "patient") {
                    $sql = "SELECT * FROM patient WHERE Num_secu=$num_secu ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result2 = $stmt->fetchAll();
                    //INI
                    $nom_naiss = $result2[0]['Nom_naissance'];
                    $nom_ep = $result2[0]['Nom_ep'];
                    $prenom = $result2[0]['Prenom'];
                    $adresse = $result2[0]['Adresse'];
                    $cp = $result2[0]['Cp'];
                    $ville = $result2[0]['Ville'];
                    $email = $result2[0]['Email'];
                    $telephone = $result2[0]['Telephone'];

                    echo ' <form method="POST">';
                    echo "nom naissance : <input type='text' name='nom_naissance' value=$nom_naiss>";

                    echo "nom epouse : <input type='text' name='nom_epouse' value=$nom_ep>";

                    echo "Prenom : <input type='text' name='prenom' value=$prenom>";

                    echo "adresse : <input type='text' name='adresse' value=$adresse>";

                    echo "cp : <input type='number' name='cp' value=$cp>";

                    echo "ville : <input type='text' name='ville' value=$ville>";

                    echo "email : <input type='text' name='email' value=$email>";

                    echo "telephone : <input type='number' maxlength='10' name='telephone' value=$telephone>";

                    echo 'date naissance : <input type="date"  name="date_naissance" value="' . $result2[0]['Date_naissance'] . '">';

                    echo " <input type='hidden' name='table' value=$table>";
                    echo " <input type='hidden' name='num_secu' value=$num_secu>";

                    echo '  <input type="submit" name="form2" value="suivant" class="button"></button>';
                    echo '</form>';
                }

                //-------------------------------------------------------------------------------------COUVERTURE------------------------------------------------------------------------------------
                elseif ($table === "couverture_social") {
                    $sql = "SELECT * FROM couverture_social WHERE Num_secu=$num_secu ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result2 = $stmt->fetchAll();
                    //INI
                    $nom_mut = $result2[0]['Nom_mutuelle'];
                    $num_adh = $result2[0]['Num_adherent'];
                    $nom_secu = $result2[0]['Nom_secu'];
                    echo ' <form method="POST">';
                    //AFFICHAGE ASSURE 
                    echo 'Assure : <select name="assure" id="type_pre" required>';
                    $is_assured_selected = ($result2[0]['Assure'] == 1) ? ' selected' : '';
                    $is_not_assured_selected = ($result2[0]['Assure'] == 0) ? ' selected' : '';
                    echo "<option value='1'{$is_assured_selected}>Oui</option>";
                    echo "<option value='0'{$is_not_assured_selected}>Non</option>";
                    echo '</select>';
                    //AFFICHAGE ALD 
                    echo 'ALD : <select name="ALD" id="type_pre" required>';
                    $is_ald_selected = ($result2[0]['ALD'] == 1) ? ' selected' : '';
                    $is_not_ald_selected = ($result2[0]['ALD'] == 0) ? ' selected' : '';
                    echo "<option value='1'{$is_ald_selected}>Oui</option>";
                    echo "<option value='0'{$is_not_ald_selected}>Non</option>";
                    echo '</select>';

                    echo "nom mut : <input type='text' name='nom_mutuelle' value=$nom_mut>";

                    echo " num adh : <input type='number' maxlength='8' name='num_adherent' value=$num_adh>";

                    echo " nom secu : <input type='text' maxlength='8' name='nom_adherent' value=$nom_secu>";

                    echo " <input type='hidden' name='table' value=$table>";
                    echo " <input type='hidden' name='num_secu' value=$num_secu>";

                    echo '  <input type="submit" name="form2" value="suivant" class="button"></button>';
                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>