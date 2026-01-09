<?php
include '../includes/_session.php';
include '../includes/_feuilleliste.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Feuilles de match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Feuilles de match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <div class="actions">
        <a href="ajouterMatch_disp.php" class="btn">Préparer une nouvelle feuille</a>
    </div>
    <?php if (empty($matches_with_feuille)): ?>
        <p>Aucune feuille de match trouvée.</p>
    <?php else: ?>
        <?php foreach ($matches_with_feuille as $match): ?>
            <div class="match-sheet">
                <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ') - Résultat: ' . ($match['resultat'] ?: 'N/A')); ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Joueur</th>
                            <th>Rôle</th>
                            <th>Poste</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $feuille = getFeuilleParMatch($linkpdo, $match['id_match']);
                        foreach ($feuille as $entry):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($entry['nom'] . ' ' . $entry['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($entry['role']); ?></td>
                                <td><?php echo htmlspecialchars($entry['poste']); ?></td>
                                <td><?php echo $entry['note'] !== null ? htmlspecialchars($entry['note']) : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body></html>