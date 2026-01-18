<?php include '../includes/_session.php'; 
      include '../includes/_modifiermatch.php';
?>
<!doctype html>
<html>
<head>
    <title>Modifier un match</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Modifier un match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form method="post" action="../core/modifier_match.php">
        <input type="hidden" name="id_match" value="<?php echo htmlspecialchars($m['id_match']); ?>">
        <label>Date et heure :</label>
        <input type="datetime-local" name="date_match" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($m['date_match']))); ?>" required>

        <label>Équipe adverse :</label>
        <input type="text" name="equipe_adverse" value="<?php echo htmlspecialchars($m['equipe_adverse']); ?>" required>

        <label>Lieu :</label>
        <select name="lieu">
            <option value="Domicile" <?php if ($m['lieu']=='Domicile') echo 'selected'; ?>>Domicile</option>
            <option value="Extérieur" <?php if ($m['lieu']=='Extérieur') echo 'selected'; ?>>Extérieur</option>
        </select>

        <div class="actions">
            <input type="submit" value="Valider">
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