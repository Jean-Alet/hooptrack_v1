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

    // Vérifier si on doit supprimer l'ancien et insérer le nouveau si num_licence a changé
    $old_data = getJoueurById($linkpdo, $id);

    if (!$old_data) {
        header('Location: ../pages/equipe_disp.php');
        exit;
    }

    if ($id !== $_POST['num_licence']) {
        // Supprimer l'ancien
        deleteJoueur($linkpdo, $id);
        // Insérer le nouveau
        insertJoueur($linkpdo, $_POST['num_licence'], $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['taille'], $_POST['poids'], $_POST['nationalite'] ?? '', $_POST['statut'], $_POST['commentaires']);
    } else {
        // Mettre à jour l'existant
        updateJoueur($linkpdo, $id, $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['taille'], $_POST['poids'], $_POST['nationalite'] ?? '', $_POST['statut'], $_POST['commentaires']);
    }

    header('Location: ../pages/equipe_disp.php');
    exit;
} else {
    header('Location: ../pages/equipe_disp.php');
    exit;
}
?>