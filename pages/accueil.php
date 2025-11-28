<?php
session_start();

if (empty($_SESSION['login'])) {
    header('Location: authentification.php');
    exit;
}

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
    <nav>
        <a href="accueil.php" class="btn">Accueil</a>
        <a href="equipe.php" class="btn">Équipe</a>
        <a href="match.php" class="btn">Matchs</a>
        <a href="feuille_match.php" class="btn">Feuille</a>
        <a href="statistiques.php" class="btn">Stats</a>
        <a href="../core/déconnecter.php" class="btn">Déconnexion</a>
    </nav>
</header>

<main class="container">
    <h2>Accueil</h2>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['login']); ?>.</p>

    <div class="actions">
        <a href="equipe.php" class="btn">Consulter l'équipe</a>
        <a href="match.php" class="btn">Consulter les matchs</a>
        <a href="feuille_match.php" class="btn">Préparer feuille</a>
        <a href="statistiques.php" class="btn">Statistiques</a>
    </div>
</main>

<footer class="container">
    <?php echo date('Y'); ?> - Application Entraîneur
</footer>
</body>
</html>