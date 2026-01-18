<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!empty($_POST)) {
    $id_match = (int)($_POST['id_match'] ?? 0);
    $entrees = [];
    for ($i = 0; $i < 12; $i++) {
        if (!isset($_POST["joueur_$i"])) break;
        $num = $_POST["joueur_$i"];
        if ($num === '') continue;
        $entrees[] = [
            'num' => $num,
            'role' => $_POST["role_$i"] ?? 'Remplaçant',
            'poste' => $_POST["poste_$i"] ?? ''
        ];
    }

    // Validations
    $errors = [];

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
    }

    if (count($entrees) > 0) {
        // Au moins 5 titulaires
        $titulaires = array_filter($entrees, fn($e) => $e['role'] === 'Titulaire');
        if (count($titulaires) < 5) {
            $errors[] = "Il faut au moins 5 joueurs titulaires.";
        }

        // Joueurs uniques
        $nums = array_column($entrees, 'num');
        if (count($nums) !== count(array_unique($nums))) {
            $errors[] = "Un joueur ne peut pas être sélectionné plusieurs fois.";
        }

        // Postes uniques pour titulaires
        $postes_tit = array_column(array_filter($entrees, fn($e) => $e['role'] === 'Titulaire'), 'poste');
        if (count($postes_tit) !== count(array_unique($postes_tit))) {
            $errors[] = "Deux titulaires ne peuvent pas avoir le même poste.";
        }
    }

    if (!empty($errors)) {
        $error_msg = implode(' ', $errors);
        
        // Déterminer si c'est une modification ou une nouvelle préparation
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $is_modification = strpos($referer, 'modifierFeuilleMatch') !== false;
        
        if ($is_modification) {
            // Si modification, rester sur la page de modification
            $_SESSION['error'] = $error_msg;
            $_SESSION['post_data'] = $_POST;
            header("Location: ../pages/modifierFeuilleMatch_disp.php?match_id=" . $id_match);
        } else {
            // Si préparation nouvelle, rester sur la page de préparation
            $_SESSION['error'] = $error_msg;
            $_SESSION['post_data'] = $_POST;
            header("Location: ../pages/preparerFeuilleMatch_disp.php");
        }
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
            $err = 'Erreur lors de la création de la feuille.';
            
            // Déterminer si c'est une modification ou une nouvelle préparation
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            $is_modification = strpos($referer, 'modifierFeuilleMatch') !== false;
            
            if ($is_modification) {
                $_SESSION['error'] = $err;
                $_SESSION['post_data'] = $_POST;
                header("Location: ../pages/modifierFeuilleMatch_disp.php?match_id=" . $id_match);
            } else {
                $_SESSION['error'] = $err;
                $_SESSION['post_data'] = $_POST;
                header("Location: ../pages/preparerFeuilleMatch_disp.php");
            }
            exit;
        }
    }
}

header('Location: ../pages/feuille_match_disp.php');
exit;
?>