<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_match'])) {
        header('Location: ../pages/match_disp.php');
        exit;
    }

    $id = (int)$_POST['id_match'];
    $date_match = $_POST['date_match'] ?? '';
    $equipe = $_POST['equipe_adverse'] ?? '';
    $lieu = $_POST['lieu'] ?? 'Domicile';

    // La date ne peut pas être passée
    $newDate = strtotime($date_match);
    $currentDate = time();
    
    if ($newDate < $currentDate) {
        header('Location: ../pages/modifierMatch_disp.php?match_id=' . $id . '&error=La date du match ne peut pas être dans le passé.');
        exit;
    }

    // Récupérer le match actuel pour conserver le résultat
    $m = getMatchById($linkpdo, $id);
    updateMatch($linkpdo, $id, $date_match, $equipe, $lieu, $m['resultat']);

    header('Location: ../pages/match_disp.php');
    exit;
} else {
    header('Location: ../pages/match_disp.php');
    exit;
}
?>