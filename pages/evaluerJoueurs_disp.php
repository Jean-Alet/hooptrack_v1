<?php
include '../includes/_session.php';
include '../includes/_evaluerjoueurs.php';
?>
<!doctype html>
<html><head>
    <title>Évaluer joueurs</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Évaluer les joueurs</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    
    <div class="match-info">
        <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ') - Résultat: ' . $match['resultat']); ?></h3>
    </div>
    
    <form method="post" action="../core/enregistrerEvaluations.php">
        <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
        
        <?php foreach ($feuille as $entry): ?>
            <div class="joueur-eval-row">
                <div class="joueur-eval-header">
                    <strong><?php echo htmlspecialchars($entry['nom'] . ' ' . $entry['prenom']); ?></strong>
                    <span><?php echo htmlspecialchars($entry['role']); ?></span>
                    <span><?php echo htmlspecialchars($entry['poste']); ?></span>
                    <span>Note actuelle: <?php echo $entry['note'] !== null ? htmlspecialchars($entry['note']) . '/10' : '-'; ?></span>
                </div>
                
                <div class="joueur-eval-fields">
                    <label>Note:</label>
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
                            placeholder="0-10"
                            >
                </div>
                
                <div class="joueur-eval-fields">
                    <label>Commentaire:</label>
                    <textarea name="commentaire_<?php echo $entry['num_licence']; ?>" 
                              placeholder="Ajouter un commentaire sur ce match..."
                              ><?php echo htmlspecialchars($entry['commentaire'] ?? ''); ?></textarea>
                </div>
            </div>
        <?php endforeach ?>

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