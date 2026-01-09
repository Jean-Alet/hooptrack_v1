<?php include '../includes/_linkpdo.php';

if (!isset($_GET['var1'])) {
    header('Location: ../pages/equipe.php'); exit;
}
$num = $_GET['var1'];

if (!empty($_POST)) {
    if (isset($_POST['confirm'])) {
        $sup = $linkpdo->prepare('DELETE FROM joueur WHERE num_licence = ?');
        $sup->execute([$num]);
    }
    header('Location: ../pages/equipe.php'); exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Supprimer joueur</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<form method="post">
    <p>Confirmer suppression du joueur <?php echo htmlspecialchars($num); ?> ?</p>
    <button type="submit" name="confirm" value="1">Valider suppression</button>
    <button type="submit" name="cancel" value="1">Annuler</button>
</form>
</body>
</html>