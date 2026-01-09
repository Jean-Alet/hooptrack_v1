<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!empty($_POST)) {

    $num = $_POST['num_licence'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naiss = $_POST['date_naissance'];
    $taille = $_POST['taille'] ?: null;
    $poids = $_POST['poids'] ?: null;
    $statut = $_POST['statut'];
    $commentaire = $_POST['commentaire'] ?? '';

    insertJoueur($linkpdo, $num, $nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaire);
}

header('Location: ../pages/equipe_disp.php');
exit;