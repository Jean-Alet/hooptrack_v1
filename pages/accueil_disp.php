<?php include '../includes/_session.php'; 
      include '../includes/_nav.php';?>

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

<?php include '../includes/_footer.php'; ?>
</body>
</html>