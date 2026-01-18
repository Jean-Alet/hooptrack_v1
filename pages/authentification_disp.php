<?php include '../core/authentification.php'; ?>
<!doctype html>
<html>
<head>
    <title>Authentification</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<div class="container">
    <h2>Authentification</h2>
    <?php include '../includes/_error.php'; ?>
    <form action="" method="post">
        <label>Login :</label>
        <input type="text" name="login">
        <label>Mot de passe :</label>
        <input type="password" name="mdp">
        <div class="actions">
            <input type="submit" value="Se connecter">
        </div>
    </form>
</div>
</body>
</html>