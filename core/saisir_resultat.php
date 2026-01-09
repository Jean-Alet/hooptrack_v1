<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_match']) || !isset($_POST['resultat'])) {
        header('Location: ../pages/match_disp.php');
        exit;
    }

    $id = (int)$_POST['id_match'];
    $resultat = $_POST['resultat'];

    // Validation du résultat
    if (!in_array($resultat, ['Victoire', 'Défaite', 'Nul'])) {
        header('Location: ../pages/saisirResultat_disp.php?match_id=' . $id . '&error=Résultat invalide.');
        exit;
    }

    // Vérifier que le match existe et peut recevoir un résultat
    $m = getMatchById($linkpdo, $id);
    if (!$m) {
        header('Location: ../pages/match_disp.php');
        exit;
    }

    $matchDate = strtotime($m['date_match']);
    $currentDate = time();

    if ($matchDate >= $currentDate) {
        header('Location: ../pages/match_disp.php?error=Ce match n\'a pas encore eu lieu.');
        exit;
    }

    if (!empty($m['resultat'])) {
        header('Location: ../pages/match_disp.php?error=Ce match a déjà un résultat enregistré.');
        exit;
    }

    // Mettre à jour seulement le résultat
    $maj = $linkpdo->prepare('UPDATE `match` SET resultat = ? WHERE id_match = ?');
    $maj->execute([$resultat, $id]);

    header('Location: ../pages/match_disp.php');
    exit;
} else {
    header('Location: ../pages/match_disp.php');
    exit;
}
?>