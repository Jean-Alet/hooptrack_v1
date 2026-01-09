<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && isset($_POST['id_match'])) {
        $id = (int)$_POST['id_match'];
        
        // Vérifier que le match existe et n'a pas encore eu lieu
        $m = getMatchById($linkpdo, $id);
        if (!$m) {
            header('Location: ../pages/match_disp.php?error=Match introuvable.');
            exit;
        }
        
        $matchDate = strtotime($m['date_match']);
        $currentDate = time();
        
        if ($matchDate < $currentDate) {
            header('Location: ../pages/match_disp.php?error=Impossible de supprimer un match qui a déjà eu lieu.');
            exit;
        }
        
        deleteMatch($linkpdo, $id);
    }
    header('Location: ../pages/match_disp.php'); exit;
} else {
    header('Location: ../pages/match_disp.php'); exit;
}
?>