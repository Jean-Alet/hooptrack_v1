<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['match_id'])) { header('Location: ../pages/feuille_match_disp.php'); exit; }
$id = (int)$_GET['match_id'];

$match = getMatchById($linkpdo, $id);
if (!$match) { header('Location: ../pages/feuille_match_disp.php'); exit; }

// Vérifier si le match n'a pas encore eu lieu
$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate < $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Impossible de modifier une feuille de match qui a déjà eu lieu.');
    exit;
}

$feuille = getFeuilleParMatch($linkpdo, $id);
$joueurs = getJoueurActif($linkpdo);
?>