<?php include '../includes/_linkpdo.php';
include '../includes/_queries.php';

if (!isset($_GET['var1'])) { header('Location: ../pages/match.php'); exit; }
$id = (int)$_GET['var1'];

if (!empty($_POST)) {
    if (isset($_POST['confirm'])) {
        deleteMatch($linkpdo, $id);
    }
    header('Location: ../pages/match.php'); exit;
}