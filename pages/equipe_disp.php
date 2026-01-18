<?php include '../includes/_session.php'; include '../core/equipe.php'; ?>
<!doctype html>
<html>
<head>
    <title>Équipe</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>
<div class="container">
    <h2>Équipe</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <table>
    <tr>
        <th>Numéro de Licence</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date de naissance</th>
        <th>Taille</th>
        <th>Poids</th>
        <th>Nationalité</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($data as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['num_licence']) . '</td>';
        echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['date_naissance']) . '</td>';
        echo '<td>' . htmlspecialchars($row['taille']) . '</td>';
        echo '<td>' . htmlspecialchars($row['poids']) . '</td>';
        echo '<td>' . htmlspecialchars($row['nationalite'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['statut']) . '</td>';
        echo '<td><a href="../pages/modifierJoueur_disp.php?player_id=' . urlencode($row['num_licence']) . '">Modifier</a>';
        if (!aDejaJoue($linkpdo, $row['num_licence'])) {
            echo ' | <a href="../pages/supprimerJoueur_disp.php?player_id=' . urlencode($row['num_licence']) . '">Supprimer</a>';
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </table>

    <div class="actions">
        <form action="../pages/ajouterJoueur_disp.php" method="get" class="inline">
            <button type="submit">Ajouter joueur</button>
        </form>
    </div>
</div>
<?php include '../includes/_footer.php'; ?>
</body>
</html>