<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!isset($_GET['match_id']) || !isset($_GET['joueur_id'])) {
    header('Location: ../pages/feuille_match_disp.php');
    exit;
}

$id_match = (int)$_GET['match_id'];
$joueur_id = $_GET['joueur_id'];

// Vérifier que le match n'a pas encore eu lieu
$match = getMatchById($linkpdo, $id_match);
if (!$match) {
    header('Location: ../pages/feuille_match_disp.php?error=Match introuvable.');
    exit;
}

$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate < $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Impossible de modifier une feuille de match qui a déjà eu lieu.');
    exit;
}

// Retirer le joueur de la feuille
deleteFeuilleJoueurMatch($linkpdo, $id_match, $joueur_id);

header('Location: ../pages/modifierFeuilleMatch_disp.php?match_id=' . $id_match);
exit;
?>