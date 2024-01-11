<?php
require_once('config.php');

session_start();
//Une fois la pré admission enregistrée, on aimerai pouvoir générer un PDF qui sera donné au patient (voir envoyé par mail)
//Sur le PDF, il y aura …nom, prénom , numéro de sécurité sociale , date du rdv, le service ainsi que le médecin.
if (!isset($_SESSION['username']) || $_SESSION['username'] === null || $_SESSION['username'] == '') {
    header('location:../index.php');
}
$num_secu = $_SESSION["num_secu"];
$sql = "SELECT p.Num_secu,p.Prenom,p.Nom_ep,p.Nom_naissance,h.Date,h.Heure,pe.Nom,pe.Prénom,s.Nom_service FROM patient p 
INNER JOIN hospitalisation h 
ON p.Num_secu=h.Num_secu
INNER JOIN personnel pe 
ON h.Docteur=pe.ID
INNER JOIN services s 
ON pe.Services=s.ID_service
WHERE $num_secu=p.Num_secu ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
;
// Create PDF
$pdf = new TCPDF();
$pdf->SetTitle('Patient Information PDF');
$pdf->AddPage();

// Add data to the PDF
foreach ($results as $row) {
    $pdf->Cell(0, 10, 'Patient Information', 0, 1, 'C');
    $pdf->Cell(0, 10, '--------------------------', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Patient Name: ' . $row['Prenom'] . ' ' . $row['Nom_ep'], 0, 1);
    $pdf->Cell(0, 10, 'Date of Hospitalization: ' . $row['Date'], 0, 1);
    $pdf->Cell(0, 10, 'Doctor: ' . $row['Prénom'] . ' ' . $row['Nom'], 0, 1);
    $pdf->Cell(0, 10, 'Service: ' . $row['Nom_service'], 0, 1);
    $pdf->Cell(0, 10, '--------------------------', 0, 1, 'C');
}

// Output the PDF to the browser or save to a file
$pdf->Output('patient_information.pdf', 'D'); // D for download, I for inline (display in browser)


?>