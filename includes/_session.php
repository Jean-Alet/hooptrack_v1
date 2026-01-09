<?php
session_start();
if (empty($_SESSION['login'])) {
    header('Location: ../pages/authentification_disp.php');
    exit;
}
?>