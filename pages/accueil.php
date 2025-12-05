<?php
session_start();

if (empty($_SESSION['login'])) {
    header('Location: authentification.php');
    exit;
}

include '../includes/_nav.php';

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="container">
    <div>
        <h1>Gestion équipe</h1>
        <div>Connecté : <?php echo htmlspecialchars($_SESSION['login']); ?></div>
    </div>
</header>

<footer class="container">
    <?php echo date('Y'); ?> - Application Entraîneur
</footer>
</body>
</html>