<?php include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

// Résumé victoires/défaites/nuls
$tot = [];
foreach (getResultatMatch($linkpdo) as $r) {
    $tot[$r['resultat']] = (int)$r['c'];
}
$totalMatchs = array_sum($tot);

// Stats par joueur
$liste = getJoueur($linkpdo);
$stats = [];
foreach ($liste as $p) {
    $num = $p['num_licence'];
    $stats[] = [
        'num_licence' => $num,
        'nom' => $p['nom'],
        'prenom' => $p['prenom'],
        'statut' => $p['statut'],
        'titulaire' => getNbTitulaire($linkpdo, $num),
        'remplacant' => getNbRemplacant($linkpdo, $num),
        'moyenne_note' => getMoyenneNote($linkpdo, $num),
        'poste_favori' => getPosteFavori($linkpdo, $num),
        'resultats' => getResultatJoueur($linkpdo, $num)
    ];
}

// Calculer les matches consécutifs pour chaque joueur
$all_matches = array_column(getMatch($linkpdo), 'id_match');
foreach ($stats as &$stat) {
    $consec = 0;
    foreach ($all_matches as $mid) {
        if (estDansMatch($linkpdo, $mid, $stat['num_licence'])) {
            $consec++;
        } else {
            break;
        }
    }
    $stat['consec'] = $consec;
    
    // Calcul du % de victoires
    $joue = count($stat['resultats']);
    $vic = count(array_filter($stat['resultats'], fn($r) => $r === 'Victoire'));
    $stat['pct'] = $joue ? round(100 * $vic / $joue, 2) : null;
}
unset($stat);
?>