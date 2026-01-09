<?php
include '_linkpdo.php';
include '_queries.php';

// résumé victoires/défaites/nuls
$tot = [];
foreach (getResultatMatch($linkpdo) as $r) {
    $tot[$r['resultat']] = (int)$r['c'];
}
$totalMatchs = array_sum($tot);

// stats par joueur
$liste = getJoueur($linkpdo);
$stats = [];
foreach ($liste as $p) {
    $num = $p['num_licence'];
    $tit = getNbTitulaire($linkpdo, $num);
    $remp = getNbRemplacant($linkpdo, $num);
    $moy = getMoyenneNote($linkpdo, $num);
    $best = getPosteFavori($linkpdo, $num);
    $poste_pref = $best ? $best['poste'] : '';

    $res = getResultatJoueur($linkpdo, $num);
    $joue = count($res); $vic = 0; foreach ($res as $r) if ($r === 'Victoire') $vic++;
    $pct = $joue ? round(100*$vic/$joue,2) : null;

    // matchs consécutifs joués (à partir du match le plus récent)
    $consec = 0;
    foreach ($matchIds as $mid) {
        if (estDansMatch($linkpdo, $mid, $num)) $consec++; else break;
    }

    $stats[$num] = [
        'nom' => $p['nom'].' '.$p['prenom'],
        'statut' => $p['statut'],
        'poste_pref' => $poste_pref,
        'tit' => $tit,
        'remp' => $remp,
        'moy' => $moy !== null ? round($moy,2) : null,
        'consec' => $consec,
        'pct' => $pct,
    ];
}
?>