<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: ../pages/authentification_disp.php');
exit;
?>