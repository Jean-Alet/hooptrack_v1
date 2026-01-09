<?php
include '_linkpdo.php';
include '_queries.php';

if (!isset($_GET['player_id'])) {
    header('Location: ../pages/equipe_disp.php'); exit;
}
$num = $_GET['player_id'];

$data = getJoueurById($linkpdo, $num);

if (!$data) {
    header('Location: ../pages/equipe_disp.php'); exit;
}
?>