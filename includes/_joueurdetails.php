<?php
if (!isset($joueur_details)) return;

// Récupération et fusion de l'historique
$historique_comments = getCommentairesMatchs($linkpdo, $joueur_details['num_licence']);
$historique_evaluations = getHistoriqueEvaluations($linkpdo, $joueur_details['num_licence']);

$historique = [];

// Fusionner les évaluations
foreach ($historique_evaluations as $n) {
    $key = $n['date_match'].'_'.$n['equipe_adverse'];
    $historique[$key] = [
        'date_match' => $n['date_match'],
        'equipe_adverse' => $n['equipe_adverse'],
        'note' => $n['note'],
        'commentaire' => null
    ];
}

// Fusionner les commentaires
foreach ($historique_comments as $c) {
    $key = $c['date_match'].'_'.$c['equipe_adverse'];
    if (!isset($historique[$key])) {
        $historique[$key] = [
            'date_match' => $c['date_match'],
            'equipe_adverse' => $c['equipe_adverse'],
            'note' => null,
            'commentaire' => $c['commentaire']
        ];
    } else {
        $historique[$key]['commentaire'] = $c['commentaire'];
    }
}
?>

<div class="joueur-details-box">
    <h3>Détails : <?php echo htmlspecialchars($joueur_details['nom'].' '.$joueur_details['prenom']); ?></h3>
    
    <table class="table-info">
        <tr><td><strong>Taille</strong></td><td><?php echo htmlspecialchars($joueur_details['taille'] ?? '-'); ?> cm</td></tr>
        <tr><td><strong>Poids</strong></td><td><?php echo htmlspecialchars($joueur_details['poids'] ?? '-'); ?> kg</td></tr>
        <tr><td><strong>Statut</strong></td><td><?php echo htmlspecialchars($joueur_details['statut']); ?></td></tr>
    </table>

    <h4>Historique des performances</h4>
    <?php if (!empty($historique)): ?>
    <table class="table-history">
        <thead>
            <tr>
                <th>Match</th>
                <th>Note</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historique as $h): ?>
            <tr>
                <td><?php echo htmlspecialchars(formatDateFr($h['date_match']).' - '.$h['equipe_adverse']); ?></td>
                <td><span class="badge-note"><?php echo $h['note'] !== null ? htmlspecialchars($h['note']).'/10' : '-'; ?></span></td>
                <td><small><?php echo htmlspecialchars($h['commentaire'] ?? '-'); ?></small></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Aucun historique disponible pour ce joueur.</p>
    <?php endif; ?>
</div>