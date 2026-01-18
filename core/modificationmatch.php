<?php include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!isset($_GET['var1'])) { header('Location: ../pages/match.php'); exit; }
$id = (int)$_GET['var1'];

if (!empty($_POST)) {
    $date_match = $_POST['date_match'] ?? '';
    $equipe = $_POST['equipe_adverse'] ?? '';
    $lieu = $_POST['lieu'] ?? 'Domicile';
    $resultat = $_POST['resultat'] ?? null;

    updateMatch($linkpdo, $id, $date_match, $equipe, $lieu, $resultat);

    header('Location: ../pages/match.php'); exit;
}

// lecture du match
$m = getMatchById($linkpdo, $id);
if (!$m) { header('Location: ../pages/match.php'); exit; }