<?php include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

$matchs = getMatchFutur($linkpdo);
$joueurs = getJoueurActif($linkpdo);
$joueurs_full = getJoueurActifComplet($linkpdo);

$id_match = $_GET['id_match'] ?? $_POST['id_match'] ?? null;

$feuille = [];
if ($id_match && empty($_POST)) {
    $feuille = getFeuille_Match($linkpdo, $id_match);
}

$source = [];
if (!empty($_POST)) {
    for ($i = 0; $i < 12; $i++) {
        if (!isset($_POST["player_$i"])) break;
        if ($_POST["player_$i"] === '') continue;
        $source[] = [
            'num_licence' => $_POST["player_$i"],
            'role'        => $_POST["role_$i"],
            'poste'       => $_POST["poste_$i"]
        ];
    }
} else {
    $source = $feuille;
}

$joueursIndex = [];
foreach ($joueurs_full as $j) {
    $joueursIndex[$j['num_licence']] = $j;
}

$error = $error ?? null;
$postes = ['Meneur', 'Arrière', 'Ailier', 'Ailier fort', 'Pivot'];
$max = max(12, count($source));
?>