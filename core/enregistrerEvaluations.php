<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/feuille_match_disp.php');
    exit;
}

if (!isset($_POST['id_match'])) {
    header('Location: ../pages/feuille_match_disp.php');
    exit;
}

$id_match = (int)$_POST['id_match'];

// Vérifier que le match a eu lieu et a un résultat
$match = getMatchById($linkpdo, $id_match);
if (!$match) {
    header('Location: ../pages/feuille_match_disp.php?error=Match introuvable.');
    exit;
}

$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate >= $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Ce match n\'a pas encore eu lieu.');
    exit;
}

if (empty($match['resultat'])) {
    header('Location: ../pages/feuille_match_disp.php?error=Ce match n\'a pas de résultat enregistré.');
    exit;
}

// Traiter les évaluations
$feuille = getFeuilleParMatch($linkpdo, $id_match);
$updated = 0;

foreach ($feuille as $entry) {
    $noteKey = 'note_' . $entry['num_licence'];
    $commentaireKey = 'commentaire_' . $entry['num_licence'];
    
    if ((isset($_POST[$noteKey]) && $_POST[$noteKey] !== '') || (isset($_POST[$commentaireKey]) && $_POST[$commentaireKey] !== '')) {
        // Enregistrer la note
        if (isset($_POST[$noteKey]) && $_POST[$noteKey] !== '') {
            $note = (float)$_POST[$noteKey];
            
            // Validation de la note (0-10)
            if ($note >= 0 && $note <= 10) {
                updateFeuilleMatchNote($linkpdo, $id_match, $entry['num_licence'], $note);
                $updated++;
            }
        }
        
        // Enregistrer le commentaire
        if (isset($_POST[$commentaireKey]) && $_POST[$commentaireKey] !== '') {
            $commentaire = $_POST[$commentaireKey];
            updateFeuilleMatchCommentaire($linkpdo, $id_match, $entry['num_licence'], $commentaire);
        }
    }
}

header('Location: ../pages/evaluerJoueurs_disp.php?match_id=' . $id_match . '&success=' . $updated . ' évaluation(s) enregistrée(s).');
exit;
?>