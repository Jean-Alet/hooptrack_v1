<?php
include '../includes/_session.php';
include '../includes/_feuillematch.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Préparer feuille de match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Préparer feuille de match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form method="post" action="../core/ajoutfeuille.php">
        <label>Match:</label>
        <select name="id_match" required>
            <?php foreach ($matchs as $m): ?>
                <option value="<?php echo $m['id_match']; ?>"><?php echo htmlspecialchars(formatDateFr($m['date_match']).' - '.$m['equipe_adverse']); ?></option>
            <?php endforeach; ?>
        </select>

        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i=0;$i<12;$i++): ?>
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
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="actions">
            <input type="submit" value="Enregistrer feuille">
        </div>
    </form>
    <form action="accueil_disp.php" method="get">
        <div class="actions">
            <button type="submit">Accueil</button>
        </div>
    </form>
</div>
</body></html>