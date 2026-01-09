<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!empty($_POST)) {

    $date = $_POST['date_match'];
    $adv = $_POST['equipe_adverse'];
    $lieu = $_POST['lieu'];
    $resultat = $_POST['resultat'] ?: null;

    insertMatch($linkpdo, $date, $adv, $lieu, $resultat);
}

header('Location: ../pages/match_disp.php');
exit;