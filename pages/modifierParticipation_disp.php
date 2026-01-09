<?php
include '../includes/_session.php';
include '../includes/_modifierparticipation.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Modifier participation</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Modifier participation</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    
    <div class="match-info">
        <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse']); ?></h3>
        <p><strong>Joueur :</strong> <?php echo htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']); ?></p>
    </div>
    
    <form method="post" action="../core/enregistrerParticipation.php">
        <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
        <input type="hidden" name="joueur_id" value="<?php echo $joueur['num_licence']; ?>">
        
        <label>Rôle :</label>
        <select name="role" required>
            <option value="Titulaire" <?php if ($participation['role'] == 'Titulaire') echo 'selected'; ?>>Titulaire</option>
            <option value="Remplaçant" <?php if ($participation['role'] == 'Remplaçant') echo 'selected'; ?>>Remplaçant</option>
        </select>
        
        <label>Poste :</label>
        <select name="poste" required>
            <option value="Meneur" <?php if ($participation['poste'] == 'Meneur') echo 'selected'; ?>>Meneur</option>
            <option value="Arrière" <?php if ($participation['poste'] == 'Arrière') echo 'selected'; ?>>Arrière</option>
            <option value="Ailier" <?php if ($participation['poste'] == 'Ailier') echo 'selected'; ?>>Ailier</option>
            <option value="Ailier fort" <?php if ($participation['poste'] == 'Ailier fort') echo 'selected'; ?>>Ailier fort</option>
            <option value="Pivot" <?php if ($participation['poste'] == 'Pivot') echo 'selected'; ?>>Pivot</option>
        </select>

        <div class="actions">
            <input type="submit" value="Enregistrer">
        </div>
    </form>
    
    <form action="modifierFeuilleMatch_disp.php?match_id=<?php echo $match['id_match']; ?>" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>
</body></html>