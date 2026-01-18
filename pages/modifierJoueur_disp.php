<?php include '../includes/_session.php'; 
      include '../includes/_modifierjoueur.php';
?>
<!doctype html>
<html>
<head>
    <title>Modifier un joueur</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Modifier un joueur</h2>
    <form action="../core/modifier_joueur.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['num_licence']); ?>">
        <label>Numéro de licence :</label>
        <input type="text" name="num_licence" value="<?php echo htmlspecialchars($data['num_licence']); ?>" required>

        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($data['nom']); ?>" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($data['prenom']); ?>" required>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" value="<?php echo htmlspecialchars($data['date_naissance']); ?>" required>

        <label>Taille (cm) :</label>
        <input type="number" name="taille" step="0.1" value="<?php echo htmlspecialchars($data['taille']); ?>">

        <label>Poids (kg) :</label>
        <input type="number" name="poids" step="0.01" value="<?php echo htmlspecialchars($data['poids']); ?>">

        <label>Nationalité :</label>
        <input type="text" name="nationalite" placeholder="ex: France" value="<?php echo htmlspecialchars($data['nationalite'] ?? ''); ?>">

        <label>Statut :</label>
        <select name="statut">
            <option value="Actif" <?php if ($data['statut'] === 'Actif') echo 'selected'; ?>>Actif</option>
            <option value="Inactif" <?php if ($data['statut'] === 'Inactif') echo 'selected'; ?>>Inactif</option>
            <option value="Blessé" <?php if ($data['statut'] === 'Blessé') echo 'selected'; ?>>Blessé</option>
            <option value="Suspendu" <?php if ($data['statut'] === 'Suspendu') echo 'selected'; ?>>Suspendu</option>
        </select>

        <label>Commentaires :</label>
        <textarea name="commentaires"><?php echo htmlspecialchars($data['commentaires']); ?></textarea>

        <div class="actions">
            <input type="submit" value="Valider">
        </div>
    </form>
</div>
</body>
</html>