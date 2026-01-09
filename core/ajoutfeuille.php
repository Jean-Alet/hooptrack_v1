<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';
// rrien d'important
if (!empty($_POST)) {
    $id_match = (int)($_POST['id_match'] ?? 0);
    $entrees = [];
    for ($i=0;$i<12;$i++) {
        if (!isset($_POST["joueur_$i"])) break;
        $num = $_POST["joueur_$i"];
        if ($num === '') continue;
        $entrees[] = ['num' => $num, 'role' => $_POST["role_$i"] ?? 'Remplaçant', 'poste' => $_POST["poste_$i"] ?? ''];
    }

    // Validations
    $errors = [];
    
    // 4. Vérifier si une feuille existe déjà
    if (FeuilleExiste($linkpdo, $id_match)) {
        $errors[] = "Une feuille de match existe déjà pour ce match.";
    }

        // Vérifier que le match n'a pas encore eu lieu
    $match = getMatchById($linkpdo, $id_match);
    if (!$match) {
        $errors[] = "Match introuvable.";
    } else {
        $matchDate = strtotime($match['date_match']);
        $currentDate = time();
        if ($matchDate < $currentDate) {
            $errors[] = "Impossible de modifier une feuille de match qui a déjà eu lieu.";
        }
    
    if (count($entrees) > 0) {
        // 1. Au moins 5 titulaires
        $titulaires = array_filter($entrees, fn($e) => $e['role'] === 'Titulaire');
        if (count($titulaires) < 5) {
            $errors[] = "Il faut au moins 5 joueurs titulaires.";
        }
        
        // 2. Joueurs uniques
        $nums = array_column($entrees, 'num');
        if (count($nums) !== count(array_unique($nums))) {
            $errors[] = "Un joueur ne peut pas être sélectionné plusieurs fois.";
        }
        
        // 3. Postes uniques pour titulaires
        $postes_tit = array_column(array_filter($entrees, fn($e) => $e['role'] === 'Titulaire'), 'poste');
        if (count($postes_tit) !== count(array_unique($postes_tit))) {
            $errors[] = "Deux titulaires ne peuvent pas avoir le même poste.";
        }
    }
    
    if (!empty($errors)) {
        $error_msg = implode(' ', $errors);
        header("Location: ../pages/feuille_match_disp.php?error=" . urlencode($error_msg));
        exit;
    }

    if ($id_match && count($entrees)) {
        $linkpdo->beginTransaction();
        try {
            deleteFeuille($linkpdo, $id_match);
            foreach ($entrees as $e) {
                insertFeuille($linkpdo, $id_match, $e['num'], $e['role'], $e['poste']);
            }
            $linkpdo->commit();
        } catch (Exception $ex) {
            $linkpdo->rollBack();
        }
    }
}}

header('Location: ../pages/feuille_match_disp.php');
exit;
?>