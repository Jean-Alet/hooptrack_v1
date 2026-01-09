<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['match_id'])) { header('Location: ../pages/feuille_match_disp.php'); exit; }
$id = (int)$_GET['match_id'];

$match = getMatchById($linkpdo, $id);
if (!$match) { header('Location: ../pages/feuille_match_disp.php'); exit; }

// Vérifier si le match a eu lieu et a un résultat
$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate >= $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Ce match n\'a pas encore eu lieu.');
    exit;
}

if (empty($match['resultat'])) {
    header('Location: ../pages/feuille_match_disp.php?error=Ce match n\'a pas de résultat enregistré.');
    exit;
}

$feuille = getFeuilleParMatch($linkpdo, $id);
?>