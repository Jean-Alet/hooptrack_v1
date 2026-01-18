<?php
include '../includes/_session.php';
include '../includes/_feuilleliste.php';

// Récupérer les détails du joueur si demandé
$joueur_details = null;
if (isset($_GET['joueur_id'])) {
    $joueur_details = getJoueurById($linkpdo, $_GET['joueur_id']);
}
?>
<!doctype html>
<html><head>
    <title>Feuilles de match</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Feuilles de match</h2>
    
    <!-- Affichage des détails du joueur si demandé -->
    <?php if ($joueur_details): ?>
        <?php include '../includes/_joueurdetails.php'; ?>
        <a href="feuille_match_disp.php">Retour</a>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <div class="actions">
        <a href="preparerFeuilleMatch_disp.php" class="btn">Préparer une nouvelle feuille</a>
    </div>
    <?php if (empty($matches_with_feuille)): ?>
        <p>Aucune feuille de match trouvée.</p>
    <?php else: ?>
        <?php foreach ($matches_with_feuille as $match): ?>
            <div class="match-sheet">
                <div class="match-header">
                    <h3><?php echo htmlspecialchars(formatDateFr($match['date_match']) . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ') - Résultat: ' . ($match['resultat'] ?: 'N/A')); ?></h3>
                    <div class="actions">
                        <?php 
                        $matchDate = strtotime($match['date_match']);
                        $currentDate = time();
                        if ($matchDate >= $currentDate): 
                        ?>
                            <a href="modifierFeuilleMatch_disp.php?match_id=<?php echo $match['id_match']; ?>" class="btn">Modifier</a>
                        <?php endif; ?>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Joueur</th>
                            <th>Rôle</th>
                            <th>Poste</th>
                            <th>Note</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $feuille = getFeuilleParMatch($linkpdo, $match['id_match']);
                        foreach ($feuille as $entry):
                        ?>
                            <tr>
                                <td><a href="?joueur_id=<?php echo htmlspecialchars($entry['num_licence']); ?>" class="joueur-link"><?php echo htmlspecialchars($entry['nom'] . ' ' . $entry['prenom']); ?></a></td>
                                <td><?php echo htmlspecialchars($entry['role']); ?></td>
                                <td><?php echo htmlspecialchars($entry['poste']); ?></td>
                                <td><?php echo $entry['note'] !== null ? htmlspecialchars($entry['note']) : '-'; ?></td>
                                <td><?php echo $entry['commentaire'] !== null && $entry['commentaire'] !== '' ? htmlspecialchars($entry['commentaire']) : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="actions">
                    <?php 
                    $matchDate = strtotime($match['date_match']);
                    $currentDate = time();
                    if ($matchDate >= $currentDate): 
                    ?>
                    <?php else: ?>
                        <a href="evaluerJoueurs_disp.php?match_id=<?php echo $match['id_match']; ?>">Évaluer joueurs</a>
                        <?php if (empty($match['resultat'])): ?>
                            <a href="saisirResultat_disp.php?match_id=<?php echo $match['id_match']; ?>">Saisir résultat</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body></html>