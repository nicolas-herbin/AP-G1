<?php
include ("config.php");
session_start();
if (!isset ($_SESSION['username']) || $_SESSION['username'] === null || $_SESSION['username'] == '') {
    header('location:../index.php');
}
;
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
    <link href="../CSS/admin.css" rel="stylesheet" />
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
                <h1>Action Administrateur</h1>

                <p class="Service"> Service : </p>

                <button class="button" onclick="window.location.href='admin/add_service.php'">Ajouter </button>
                <button class="button" onclick="window.location.href='admin/modif_service.php'">Modifier </button>
                <button class="button" onclick="window.location.href='admin/del_service.php'">Supprimer </button>


                <p class="Service"> Médecin : </p>

                <button class="button" onclick="window.location.href='admin/add_medecin.php'">Ajouter </button>
                <button class="button" onclick="window.location.href='admin/modif_doc.php'">Modifier </button>
                <button class="button" onclick="window.location.href='admin/del_medecin.php'">Supprimer </button>


                <p class="Service"> Pré Admission : </p>

                <button class="button" onclick="window.location.href='client.php'">Ajouter </button>
                <button class="button" onclick="window.location.href='admin/modif_pre.php'">Modifier </button>
                <button class="button" onclick="window.location.href='admin/del_pre.php'">Supprimer </button>
            </div>
        </div>
    </div>
</body>

</html>