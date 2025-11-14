<?php
session_start();

if (!isset($_SESSION['mdp'], $_SESSION['login']) || $_SESSION['mdp'] !== 'dupont' || $_SESSION['login'] !== 'jean') {
    header('Location: authentificationrate.php');
    exit;
}

/* 
il faut qu'on ne puisse pas voir le mdp quand on le tape
Il ne faut pas qu'il soit enregistré dans les cookies
*/
?>
    <form action="equipe.php" method="post">
        <input type="submit" value="Consulter l'équipe">
    </form>
    <form action="match.php" method="post">
        <input type="submit" value="Consulter les matchs">
    </form>