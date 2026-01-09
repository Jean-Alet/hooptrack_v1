<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['match_id']) || !isset($_GET['joueur_id'])) { 
    header('Location: ../pages/feuille_match_disp.php'); 
    exit; 
}

$id_match = (int)$_GET['match_id'];
$joueur_id = $_GET['joueur_id'];

$match = getMatchById($linkpdo, $id_match);
if (!$match) { 
    header('Location: ../pages/feuille_match_disp.php'); 
    exit; 
}

// Vérifier que le match n'a pas encore eu lieu
$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate < $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Impossible de modifier une feuille de match qui a déjà eu lieu.');
    exit;
}

$joueur = getJoueurById($linkpdo, $joueur_id);
if (!$joueur) {
    header('Location: ../pages/modifierFeuilleMatch_disp.php?match_id=' . $id_match . '&error=Joueur introuvable.');
    exit;
}

// Récupérer la participation actuelle
$participation = $linkpdo->prepare('SELECT role, poste FROM feuille_match WHERE id_match = ? AND num_licence = ?');
$participation->execute([$id_match, $joueur_id]);
$participation = $participation->fetch(PDO::FETCH_ASSOC);

if (!$participation) {
    header('Location: ../pages/modifierFeuilleMatch_disp.php?match_id=' . $id_match . '&error=Joueur non trouvé dans la feuille.');
    exit;
}
?>