<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['match_id'])) { header('Location: ../pages/match_disp.php'); exit; }
$id = (int)$_GET['match_id'];

$m = getMatchById($linkpdo, $id);
if (!$m) { header('Location: ../pages/match_disp.php'); exit; }

// Vérifier si le match a déjà eu lieu
$matchDate = strtotime($m['date_match']);
$currentDate = time();

if ($matchDate < $currentDate) {
    header('Location: ../pages/match_disp.php?error=Impossible de modifier un match qui a déjà eu lieu.');
    exit;
}
?>