<?php
session_start();

if (!isset($_SESSION['mdp'], $_SESSION['login']) || $_SESSION['mdp'] !== 'dupont' || $_SESSION['login'] !== 'jean') {
    header('Location: authentificationrate.php');
    exit;
}
?>
    <form action="equipe.php" method="post">
        <input type="submit" value="Consulter l'équipe">
    </form>
    <form action="match.php" method="post">
        <input type="submit" value="Consulter les matchs">
    </form>