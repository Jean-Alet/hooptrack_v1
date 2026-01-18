<?php include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!isset($_GET['var1'])) {
    header('Location: ../pages/equipe.php'); exit;
}
$num = $_GET['var1'];

if (!empty($_POST)) {
    if (isset($_POST['confirm'])) {
        deleteJoueur($linkpdo, $num);
    }
    header('Location: ../pages/equipe.php'); exit;
}