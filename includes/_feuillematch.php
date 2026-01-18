<?php
include '_linkpdo.php';
include '_queries.php';

// matchs à venir 
$tous_les_matchs = getMatchFutur($linkpdo);

// Filtrer pour ne garder que les matchs sans feuille existante
$matchs = [];
foreach ($tous_les_matchs as $m) {
    if (!feuilleExiste($linkpdo, $m['id_match'])) {
        $matchs[] = $m;
    }
}

// joueurs actifs
$joueurs = getJoueurActif($linkpdo);
?>