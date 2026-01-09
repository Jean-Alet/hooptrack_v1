<?php
include '../includes/_session.php';
include '../includes/_statistiques.php';
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Statistiques</title>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Statistiques de l'Équipe</h2>

    <div class="stats-summary">
        <div class="stat-item victory">
            <div class="stat-number"><?php echo htmlspecialchars($tot['Victoire'] ?? 0); ?></div>
            <div class="stat-label">Victoires</div>
            <div class="stat-percentage">(<?php echo $totalMatchs > 0 ? round((($tot['Victoire'] ?? 0) / $totalMatchs) * 100, 1) : 0; ?>%)</div>
        </div>
        <div class="stat-item defeat">
            <div class="stat-number"><?php echo htmlspecialchars($tot['Défaite'] ?? 0); ?></div>
            <div class="stat-label">Défaites</div>
            <div class="stat-percentage">(<?php echo $totalMatchs > 0 ? round((($tot['Défaite'] ?? 0) / $totalMatchs) * 100, 1) : 0; ?>%)</div>
        </div>
        <div class="stat-item draw">
            <div class="stat-number"><?php echo htmlspecialchars($tot['Nul'] ?? 0); ?></div>
            <div class="stat-label">Nuls</div>
            <div class="stat-percentage">(<?php echo $totalMatchs > 0 ? round((($tot['Nul'] ?? 0) / $totalMatchs) * 100, 1) : 0; ?>%)</div>
        </div>
        <div class="stat-item total">
            <div class="stat-number"><?php echo htmlspecialchars($totalMatchs); ?></div>
            <div class="stat-label">Total Matchs</div>
            <div class="stat-percentage">Saison en cours</div>
        </div>
    </div>

    <div class="players-section">
        <h2>Statistiques des Joueurs</h2>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Statut</th>
                    <th>Poste préféré</th>
                    <th>Titulaires</th>
                    <th>Remplaçants</th>
                    <th>Moyenne notes</th>
                    <th>Matchs consécutifs</th>
                    <th>% Victoires</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats as $s):
                    $statusClass = 'status-' . strtolower($s['statut']);
                    $pctClass = '';
                    if ($s['pct'] !== null) {
                        if ($s['pct'] >= 70) $pctClass = 'high';
                        elseif ($s['pct'] >= 50) $pctClass = 'medium';
                        else $pctClass = 'low';
                    }
                ?>
                <tr>
                    <td><span class="player-name"><?php echo htmlspecialchars($s['nom']); ?></span></td>
                    <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($s['statut']); ?></span></td>
                    <td><span class="poste-badge"><?php echo htmlspecialchars($s['poste_pref']); ?></span></td>
                    <td><?php echo htmlspecialchars($s['tit']); ?></td>
                    <td><?php echo htmlspecialchars($s['remp']); ?></td>
                    <td><span class="note-moyenne"><?php echo $s['moy'] !== null ? htmlspecialchars($s['moy']) : '-'; ?></span></td>
                    <td><span class="consecutifs"><?php echo htmlspecialchars($s['consec']); ?></span></td>
                    <td><span class="pourcentage-victoire <?php echo $pctClass; ?>"><?php echo $s['pct'] !== null ? htmlspecialchars($s['pct']).'%' : '-'; ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body></html>