<?php include '../includes/_linkpdo.php';

if (!isset($_GET['var1'])) { header('Location: ../pages/match.php'); exit; }
$id = (int)$_GET['var1'];

if (!empty($_POST)) {
    $date_match = $_POST['date_match'] ?? '';
    $equipe = $_POST['equipe_adverse'] ?? '';
    $lieu = $_POST['lieu'] ?? 'Domicile';
    $resultat = $_POST['resultat'] ?? null;

    $maj = $linkpdo->prepare(query: 'UPDATE `match` SET date_match = ?, equipe_adverse = ?, lieu = ?, resultat = ? WHERE id_match = ?');
    $maj->execute([$date_match, $equipe, $lieu, $resultat === '' ? null : $resultat, $id]);

    header('Location: ../pages/match.php'); exit;
}

// lecture du match
$sel = $linkpdo->prepare('SELECT id_match, date_match, equipe_adverse, lieu, resultat FROM `match` WHERE id_match = ?');
$sel->execute([$id]);
$m = $sel->fetch(PDO::FETCH_ASSOC);
if (!$m) { header('Location: ../pages/match.php'); exit; }
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Modifier match</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<form method="post">
    Date et heure: <input type="datetime-local" name="date_match" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($m['date_match']))); ?>" required><br>
    Equipe adverse: <input name="equipe_adverse" value="<?php echo htmlspecialchars($m['equipe_adverse']); ?>"><br>
    Lieu: <select name="lieu"><option<?php if ($m['lieu']=='Domicile') echo ' selected'; ?>>Domicile</option><option<?php if ($m['lieu']=='Extérieur') echo ' selected'; ?>>Extérieur</option></select><br>
    Résultat: <select name="resultat"><option value="">--</option><option<?php if ($m['resultat']=='Victoire') echo ' selected'; ?>>Victoire</option><option<?php if ($m['resultat']=='Défaite') echo ' selected'; ?>>Défaite</option></select><br>
    <input type="submit" value="Valider">
</form>
<form action="../pages/match.php" method="get"><button type="submit">Retour</button></form>
</body></html>