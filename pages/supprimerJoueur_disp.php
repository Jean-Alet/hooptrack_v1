<?php include '../includes/_session.php'; 
      include '../includes/_supprimerjoueur.php';
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Supprimer joueur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Supprimer un joueur</h2>
    <p>Confirmer la suppression du joueur <strong><?php echo htmlspecialchars($data['nom'] . ' ' . $data['prenom']); ?></strong> (Licence: <?php echo htmlspecialchars($num); ?>) ?</p>
    <form method="post" action="../core/supprimer_joueur.php">
        <input type="hidden" name="num_licence" value="<?php echo htmlspecialchars($num); ?>">
        <div class="actions">
            <button type="submit" name="confirm" value="1">Valider suppression</button>
            <button type="submit" name="cancel" value="1">Annuler</button>
        </div>
    </form>
</div>
</body>
</html>