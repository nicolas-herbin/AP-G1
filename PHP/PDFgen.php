<?php
// Inclure la bibliothèque FPDF
session_start();
require ('fpdf/fpdf.php');
include_once ("config.php");

// Récupérer le numéro de sécurité sociale de la session
$num_secu = $_SESSION["num_secu"];
//just for testing purpose
// Requête SQL
$sql = "SELECT p.Num_secu, p.Prenom, p.Nom_ep, h.Date, h.Heure, pe.Nom AS MedecinNom, pe.Prénom AS MedecinPrenom, s.Nom_service 
        FROM patient p 
        INNER JOIN hospitalisation h ON p.Num_secu = h.Num_secu
        INNER JOIN personnel pe ON h.Docteur = pe.ID
        INNER JOIN services s ON pe.Services = s.ID_service
        WHERE p.Num_secu = $num_secu
        ORDER BY Date";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

$sql = "SELECT count(*) FROM hospitalisation H where Num_secu= $num_secu";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result2 = $stmt->fetchAll();
$nbr_rdv = $result2[0][0];

// Création du PDF avec FPDF
// AAAAAAAAAAAAAAAAAAAAAAAAAAAA 
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
// Ajout du logo et nom de l'entreprise en haut à droite
$pdf->Image('../IMG/10130-removebg-preview copie.png', 10, 10, 50); // À adapter selon votre logo
$pdf->SetXY(60, 25); // Position pour le nom de l'entreprise
$pdf->Cell(20, 10, 'CLINIQUE LPFS', 0, 1, 'C');
$pdf->SetXY(140, 25); // Position pour le nom de l'entreprise
$pdf->Cell(200, 10, 'Num Secu :  ' . $result[0]['Num_secu']);

// Saut de ligne pour laisser de l'espace
$pdf->Ln(40);

// Affichage des informations récupérées
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nom: ' . $result[0]['Nom_ep']);
$pdf->Ln(); // Saut de ligne
$pdf->Cell(50, 10, 'Prenom: ' . $result[0]['Prenom']);

// Titre des informations du rendez-vous
$pdf->Ln(20);
$pdf->Cell(0, 10, 'Informations des rendez-vous : ', 0, 1, 'C');

// Saut de ligne
$pdf->Ln(10);

for ($i = 0; $i < $nbr_rdv; $i++) {
    // Affichage des informations récupérées
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(); // Saut de ligne
    $pdf->Cell(40, 10, 'Date du rendez-vous: ' . $result[$i]['Date']);
    $pdf->Ln(); // Saut de ligne
    $pdf->Cell(40, 10, 'Heure du rendez-vous: ' . $result[$i]['Heure']);
    $pdf->Ln(); // Saut de ligne
    $pdf->Cell(40, 10, 'Medecin: ' . $result[$i]['MedecinPrenom'] . ' ' . $result[$i]['MedecinNom']);
    $pdf->Ln(); // Saut de ligne
    $pdf->Cell(40, 10, 'Service: ' . $result[$i]['Nom_service']);
    $pdf->Ln(10); // Saut de ligne
    $pdf->Cell(0, 10, '______________________________', 0, 1, 'C');
    $pdf->Ln(10); // Saut de ligne
}

// Nom du fichier PDF à générer
$filename = 'CliniqueLPFS_RendezVous.pdf';

// Sauvegarde du fichier PDF sur le serveur
$pdf->Output($filename, 'F');

// Fermeture de la connexion à la base de données
$conn = null;

// Téléchargement du fichier PDF généré
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Suppression du fichier PDF après téléchargement
unlink($filename);

?>