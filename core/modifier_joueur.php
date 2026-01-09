<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        header('Location: ../pages/equipe_disp.php');
        exit;
    }

    $id = $_POST['id'];

    // Check if we need to delete old and insert new if num_licence changed
    $old_data = getJoueurById($linkpdo, $id);

    if (!$old_data) {
        header('Location: ../pages/equipe_disp.php');
        exit;
    }

    if ($id !== $_POST['num_licence']) {
        // Delete old
        deleteJoueur($linkpdo, $id);
        // Insert new
        insertJoueur($linkpdo, $_POST['num_licence'], $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['taille'], $_POST['poids'], $_POST['statut'], $_POST['commentaires']);
    } else {
        // Update
        updateJoueur($linkpdo, $id, $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['taille'], $_POST['poids'], $_POST['statut'], $_POST['commentaires']);
    }

    header('Location: ../pages/equipe_disp.php');
    exit;
} else {
    header('Location: ../pages/equipe_disp.php');
    exit;
}
?>