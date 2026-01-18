<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

$matches = getMatch($linkpdo);
?>
<!doctype html>
<html>
<head>
    <title>Match</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Matchs</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <table>
    <tr>
        <th>ID</th>
        <th>Date & heure</th>
        <th>Équipe adverse</th>
        <th>Lieu</th>
        <th>Score</th>
        <th>Résultat</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($matches as $row) {
        $matchDate = strtotime($row['date_match']);
        $currentDate = time();
        $isPast = $matchDate < $currentDate;
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id_match']) . '</td>';
        echo '<td>' . htmlspecialchars(formatDateFr($row['date_match'])) . '</td>';
        echo '<td>' . htmlspecialchars($row['equipe_adverse']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lieu']) . '</td>';
        
        if ($row['score_equipe'] !== null) {
            echo '<td>' . htmlspecialchars($row['score_equipe'] . ' - ' . $row['score_adverse']) . '</td>';
        } else {
            echo '<td>-</td>';
        }
        
        $resText = $row['resultat'] ?: 'N/A';
        if (!empty($row['overtime'])) {
            $resText .= ' (OT)';
        }
        echo '<td>' . htmlspecialchars($resText) . '</td>';
        
        echo '<td>';
        if (!$isPast) {
            echo '<a href="../pages/modifierMatch_disp.php?match_id=' . urlencode($row['id_match']) . '">Modifier</a> | ';
            echo '<a href="../pages/supprimerMatch_disp.php?match_id=' . urlencode($row['id_match']) . '">Supprimer</a>';
        } else {
            if (empty($row['resultat']) || $row['score_equipe'] === null || $row['score_adverse'] === null) {
                echo '<a href="../pages/saisirResultat_disp.php?match_id=' . urlencode($row['id_match']) . '">Saisir résultat</a>';
            } else {
                echo '<span class="text-muted">-</span>';
            }
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </table>

    <div class="actions">
        <form action="../pages/ajouterMatch_disp.php" method="get" class="inline">
            <button type="submit">Ajouter match</button>
        </form>
    </div>
</div>
</body>