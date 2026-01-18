<?php 
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

// Traiter le POST si c'est une modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_licence = $_POST['num_licence'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $taille = $_POST['taille'] ?: null;
    $poids = $_POST['poids'] ?: null;
    $nationalite = $_POST['nationalite'] ?? '';
    $statut = $_POST['statut'] ?? '';
    $commentaires = $_POST['commentaires'] ?? '';
    
    if ($num_licence && $nom && $prenom && $date_naissance) {
        updateJoueur($linkpdo, $num_licence, $nom, $prenom, $date_naissance, $taille, $poids, $nationalite, $statut, $commentaires);
        header('Location: ../pages/equipe.php');
        exit;
    }
}

if (!isset($_GET['var1'])) {
    header('Location: ../pages/equipe.php');
    exit;
}

$num = $_GET['var1'];
$data = getJoueurById($linkpdo, $num);

if (!$data) {
    header('Location: ../pages/equipe.php');
    exit;
}
?>