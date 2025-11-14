<?php session_start(); ?>
<html>

<head>
    <?php
    $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
    $login = isset($_POST['login']) ? $_POST['login'] : "";
    $_SESSION['login'] = $login;
    $_SESSION['mdp'] = $mdp;
    ?>
</head>
<!-- à changer car on veut que ça soit crypter -->
<body>
    <form action="accueil.php" method="post">
        Login :<input type="text" name="login">
        Mot de passe : <input type="text" name="mdp">
        <input type="submit" value="Envoyer">
    </form>
    <br />


</body>

</html>