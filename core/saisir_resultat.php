<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_match']) || !isset($_POST['score_equipe']) || !isset($_POST['score_adverse'])) {
        header('Location: ../pages/match_disp.php');
        exit;
    }

    $id = (int)$_POST['id_match'];
    $score_equipe = (int)$_POST['score_equipe'];
    $score_adverse = (int)$_POST['score_adverse'];

    $overtime = isset($_POST['overtime']) && $_POST['overtime'] == '1' ? 1 : 0;

    if ($score_equipe < 0 || $score_adverse < 0) {
        header('Location: ../pages/saisirResultat_disp.php?match_id=' . $id . '&error=Les scores doivent être positifs.');
        exit;
    }

    if ($score_equipe === $score_adverse) {
        header('Location: ../pages/saisirResultat_disp.php?match_id=' . $id . '&error=Pas de match nul en basketball.');
        exit;
    }

    if ($score_equipe > $score_adverse) {
        $resultat = 'Victoire';
    } else {
        $resultat = 'Défaite';
    }
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

    if (!is_null($m['score_equipe']) || !is_null($m['score_adverse'])) {
        header('Location: ../pages/match_disp.php?error=Ce match a déjà un résultat enregistré.');
        exit;
    }

    $maj = $linkpdo->prepare('UPDATE `match` SET resultat = ?, score_equipe = ?, score_adverse = ?, overtime = ? WHERE id_match = ?');
    $maj->execute([$resultat, $score_equipe, $score_adverse, $overtime, $id]);

    header('Location: ../pages/match_disp.php');
    exit;
} else {
    header('Location: ../pages/match_disp.php');
    exit;
}
?>