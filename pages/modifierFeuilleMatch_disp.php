<?php
include '../includes/_session.php';
include '../includes/_modifierfeuille.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Modifier feuille de match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Modifier feuille de match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    
    <div class="match-info">
        <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ')'); ?></h3>
    </div>
    
    <form method="post" action="../core/ajoutfeuille.php">
        <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
        
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feuille as $i => $e): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($e['nom'] . ' ' . $e['prenom']); ?></td>
                        <td>
                            <select name="role_<?php echo $i; ?>">
                                <option value="Titulaire" <?php if ($e['role'] == 'Titulaire') echo 'selected'; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php if ($e['role'] == 'Remplaçant') echo 'selected'; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <select name="poste_<?php echo $i; ?>">
                                <option value="Meneur" <?php if ($e['poste'] == 'Meneur') echo 'selected'; ?>>Meneur</option>
                                <option value="Arrière" <?php if ($e['poste'] == 'Arrière') echo 'selected'; ?>>Arrière</option>
                                <option value="Ailier" <?php if ($e['poste'] == 'Ailier') echo 'selected'; ?>>Ailier</option>
                                <option value="Ailier fort" <?php if ($e['poste'] == 'Ailier fort') echo 'selected'; ?>>Ailier fort</option>
                                <option value="Pivot" <?php if ($e['poste'] == 'Pivot') echo 'selected'; ?>>Pivot</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="joueur_<?php echo $i; ?>" value="<?php echo $e['num_licence']; ?>">
                            <a href="../core/retirerJoueur.php?match_id=<?php echo $match['id_match']; ?>&joueur_id=<?php echo $e['num_licence']; ?>">Retirer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <?php for ($i = count($feuille); $i < count($feuille) + 5; $i++): ?>
                    <tr>
                        <td>
                            <select name="joueur_<?php echo $i; ?>">
                                <option value="">-- joueur --</option>
                                <?php foreach ($joueurs as $j): ?>
                                    <option value="<?php echo htmlspecialchars($j['num_licence']); ?>"><?php echo htmlspecialchars($j['nom'].' '.$j['prenom']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="role_<?php echo $i; ?>">
                                <option value="Titulaire">Titulaire</option>
                                <option value="Remplaçant">Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <select name="poste_<?php echo $i; ?>">
                                <option>Meneur</option><option>Arrière</option><option>Ailier</option><option>Ailier fort</option><option>Pivot</option>
                            </select>
                        </td>
                        <td>-</td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="actions">
            <input type="submit" value="Mettre à jour feuille">
        </div>
    </form>
    
    <form action="feuille_match_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>
</body></html>