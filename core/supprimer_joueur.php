<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && isset($_POST['num_licence'])) {
        $num = $_POST['num_licence'];
        if (aDejaJoue($linkpdo, $num)) {
            // Redirect with error
            header('Location: ../pages/equipe_disp.php?error=Impossible de supprimer un joueur qui a participé à un match.');
            exit;
        }
        deleteJoueur($linkpdo, $num);
    }
    header('Location: ../pages/equipe_disp.php'); exit;
} else {
    header('Location: ../pages/equipe_disp.php'); exit;
}
?>