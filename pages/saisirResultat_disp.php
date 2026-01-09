<?php include '../includes/_session.php';
      include '../includes/_saisirresultat.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Saisir résultat</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Saisir le résultat du match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    
    <div class="match-info">
        <p><strong>Match :</strong> <?php echo htmlspecialchars($m['equipe_adverse']); ?> (<?php echo htmlspecialchars($m['lieu']); ?>)</p>
        <p><strong>Date :</strong> <?php echo htmlspecialchars($m['date_match']); ?></p>
    </div>
    
    <form method="post" action="../core/saisir_resultat.php">
        <input type="hidden" name="id_match" value="<?php echo htmlspecialchars($m['id_match']); ?>">
        
        <label>Résultat :</label>
        <select name="resultat" required>
            <option value="">-- Choisir --</option>
            <option value="Victoire">Victoire</option>
            <option value="Défaite">Défaite</option>
            <option value="Nul">Nul</option>
        </select>

        <div class="actions">
            <input type="submit" value="Enregistrer le résultat">
        </div>
    </form>

    <form action="match_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>
</body>
</html>