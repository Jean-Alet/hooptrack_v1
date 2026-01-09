<?php
include '../includes/_session.php';
include '../includes/_evaluerjoueurs.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Évaluer joueurs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Évaluer les joueurs</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    
    <div class="match-info">
        <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ') - Résultat: ' . $match['resultat']); ?></h3>
    </div>
    
    <form method="post" action="../core/enregistrerEvaluations.php">
        <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
        
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                    <th>Note actuelle</th>
                    <th>Nouvelle note (0-10)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feuille as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['nom'] . ' ' . $entry['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($entry['role']); ?></td>
                        <td><?php echo htmlspecialchars($entry['poste']); ?></td>
                        <td><?php echo $entry['note'] !== null ? htmlspecialchars($entry['note']) : '-'; ?></td>
                        <td>
                            <input  type="number" 
                                    name="note_<?php echo $entry['num_licence']; ?>" 
                                    min="0" 
                                    max="10" 
                                    step="0.5" 
                                    value="<?php if ($entry['note'] !== null) { 
                                                    echo htmlspecialchars($entry['note']); 
                                                } else { 
                                                    echo ''; }
                                        ?>"
                                    placeholder="0-10">
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="actions">
            <input type="submit" value="Enregistrer les évaluations">
        </div>
    </form>
    
    <form action="feuille_match_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>
</body></html>