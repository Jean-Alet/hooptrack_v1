<?php
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

session_start();
$error = '';
$login = isset($_POST['login']) ? $_POST['login'] : '';
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';

if (!empty($_POST)) {
    if ($login === '' || $mdp === '') { 
        $error = 'Remplissez tous les champs.';
    } else {
        try {
            $mdphash = passwordHash($linkpdo, $login);
            
            if ($mdphash === false) {
                $error = 'Utilisateur introuvable.';
            } elseif (!password_verify($mdp, $mdphash)) {
                $error = 'Mot de passe incorrect.';
            } else {
                $_SESSION['login'] = $login;
                header('Location: accueil.php');
                exit;
            }
        } catch (Exception $e) {
            $error = 'Erreur BDD';
        }
    }
}