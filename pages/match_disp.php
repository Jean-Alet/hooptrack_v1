<?php
include '../includes/_session.php';
include '../includes/_linkpdo.php';
include '../includes/_queries.php';

include '../includes/_nav.php';

$matches = getMatch($linkpdo);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Matchs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Matchs</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <table>
    <tr>
        <th>ID</th>
        <th>Date & heure</th>
        <th>Équipe adverse</th>
        <th>Lieu</th>
        <th>Résultat</th>
        <th>Modifier / Supprimer</th>
    </tr>
    <?php
    foreach ($matches as $row) {
        $matchDate = strtotime($row['date_match']);
        $currentDate = time();
        $isPast = $matchDate < $currentDate;
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id_match']) . '</td>';
        echo '<td>' . htmlspecialchars($row['date_match']) . '</td>';
        echo '<td>' . htmlspecialchars($row['equipe_adverse']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lieu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['resultat']) . '</td>';
        echo '<td>';
        if (!$isPast) {
            echo '<a href="../pages/modifierMatch_disp.php?match_id=' . urlencode($row['id_match']) . '">Modifier</a> | ';
            echo '<a href="../pages/supprimerMatch_disp.php?match_id=' . urlencode($row['id_match']) . '">Supprimer</a>';
        } else {
            echo '<span style="color: #999;">-</span>';
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </table>

    <div class="actions">
        <form action="../pages/ajouterMatch_disp.php" method="get" style="display:inline;">
            <button type="submit">Ajouter match</button>
        </form>
        <form action="accueil_disp.php" method="get" style="display:inline;">
            <button type="submit">Accueil</button>
        </form>
    </div>
</div>
</body>