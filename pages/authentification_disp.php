<?php include '../core/authentification.php'; ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Authentification</title>
    <link rel="stylesheet" href="../css/style.css">
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
            <input type="submit" value="Envoyer">
        </div>
    </form>
</div>
</body>
</html>