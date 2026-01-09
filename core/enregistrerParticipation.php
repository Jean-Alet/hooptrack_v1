<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/feuille_match_disp.php');
    exit;
}

if (!isset($_POST['id_match']) || !isset($_POST['joueur_id']) || !isset($_POST['role']) || !isset($_POST['poste'])) {
    header('Location: ../pages/feuille_match_disp.php');
    exit;
}

$id_match = (int)$_POST['id_match'];
$joueur_id = $_POST['joueur_id'];
$role = $_POST['role'];
$poste = $_POST['poste'];

// Validation des données
$validRoles = ['Titulaire', 'Remplaçant'];
$validPostes = ['Meneur', 'Arrière', 'Ailier', 'Ailier fort', 'Pivot'];

if (!in_array($role, $validRoles) || !in_array($poste, $validPostes)) {
    header('Location: ../pages/modifierParticipation_disp.php?match_id=' . $id_match . '&joueur_id=' . $joueur_id . '&error=Données invalides.');
    exit;
}

// Vérifier que le match n'a pas encore eu lieu
$match = getMatchById($linkpdo, $id_match);
if (!$match) {
    header('Location: ../pages/feuille_match_disp.php?error=Match introuvable.');
    exit;
}

$matchDate = strtotime($match['date_match']);
$currentDate = time();

if ($matchDate < $currentDate) {
    header('Location: ../pages/feuille_match_disp.php?error=Impossible de modifier une feuille de match qui a déjà eu lieu.');
    exit;
}

// Mettre à jour la participation
$update = $linkpdo->prepare('UPDATE feuille_match SET role = ?, poste = ? WHERE id_match = ? AND num_licence = ?');
$update->execute([$role, $poste, $id_match, $joueur_id]);

header('Location: ../pages/modifierFeuilleMatch_disp.php?match_id=' . $id_match . '&success=Participation mise à jour.');
exit;
?>