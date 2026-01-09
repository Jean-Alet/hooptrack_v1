<?php
include '_linkpdo.php';
include '_queries.php';

// matchs à venir 
$matchs = getMatchFutur($linkpdo);

// joueurs actifs
$joueurs = getJoueurActif($linkpdo);
?>