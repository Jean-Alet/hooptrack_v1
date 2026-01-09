<?php include '../includes/_session.php'; 
      include '../includes/_supprimermatch.php';
?>
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Supprimer match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Supprimer un match</h2>
    <p>Confirmer la suppression du match contre <strong><?php echo htmlspecialchars($m['equipe_adverse']); ?></strong> le <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($m['date_match']))); ?> ?</p>
    <form method="post" action="../core/supprimer_match.php">
        <input type="hidden" name="id_match" value="<?php echo htmlspecialchars($id); ?>">
        <div class="actions">
            <button type="submit" name="confirm" value="1">Valider suppression</button>
            <button type="submit" name="cancel" value="1">Annuler</button>
        </div>
    </form>
</div>
</body>
</html>