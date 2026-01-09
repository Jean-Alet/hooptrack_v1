<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['match_id'])) { header('Location: ../pages/match_disp.php'); exit; }
$id = (int)$_GET['match_id'];

$m = getMatchById($linkpdo, $id);
if (!$m) { header('Location: ../pages/match_disp.php'); exit; }

// Vérifier que le match a eu lieu et n'a pas de résultat
$matchDate = strtotime($m['date_match']);
$currentDate = time();

if ($matchDate >= $currentDate) {
    header('Location: ../pages/match_disp.php?error=Ce match n\'a pas encore eu lieu.');
    exit;
}

if (!is_null($m['score_equipe'])) {
    header('Location: ../pages/match_disp.php?error=Ce match a déjà un score enregistré.');
    exit;
}
?>