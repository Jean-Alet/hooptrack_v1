<?php
// connexion DB
try {
    $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur BDD');
}

// résumé victoires/défaites/nuls
$stmt = $linkpdo->query("SELECT resultat, COUNT(*) as c FROM `match` GROUP BY resultat");
$tot = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    $tot[$r['resultat']] = (int)$r['c'];
}
$totalMatchs = array_sum($tot);

// stats par joueur
$liste = $linkpdo->query('SELECT num_licence, nom, prenom, statut FROM joueur ORDER BY nom, prenom')->fetchAll(PDO::FETCH_ASSOC);
$stats = [];
foreach ($liste as $p) {
    $num = $p['num_licence'];
    $q = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE num_licence = ? AND role = 'Titulaire'");
    $q->execute([$num]); $tit = (int)$q->fetchColumn();
    $q = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE num_licence = ? AND role = 'Remplaçant'");
    $q->execute([$num]); $remp = (int)$q->fetchColumn();
    $q = $linkpdo->prepare("SELECT AVG(note) FROM feuille_match WHERE num_licence = ? AND note IS NOT NULL");
    $q->execute([$num]); $moy = $q->fetchColumn();
    $q = $linkpdo->prepare("SELECT poste, COUNT(*) as c FROM feuille_match WHERE num_licence = ? GROUP BY poste ORDER BY c DESC LIMIT 1");
    $q->execute([$num]); $best = $q->fetch(PDO::FETCH_ASSOC);
    $poste_pref = $best ? $best['poste'] : '';

    $q = $linkpdo->prepare("SELECT m.resultat FROM feuille_match f JOIN `match` m ON f.id_match = m.id_match WHERE f.num_licence = ?");
    $q->execute([$num]); $res = $q->fetchAll(PDO::FETCH_COLUMN);
    $joue = count($res); $vic = 0; foreach ($res as $r) if ($r === 'Victoire') $vic++;
    $pct = $joue ? round(100*$vic/$joue,2) : null;

    // matchs consécutifs joués
    $q = $linkpdo->query("SELECT id_match FROM `match` ORDER BY date_match DESC");
    $all = $q->fetchAll(PDO::FETCH_COLUMN);
    $consec = 0;
    foreach ($all as $mid) {
        $q2 = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE id_match = ? AND num_licence = ?");
        $q2->execute([$mid, $num]);
        if ($q2->fetchColumn() > 0) $consec++; else break;
    }

    $stats[$num] = [
        'nom' => $p['nom'].' '.$p['prenom'],
        'statut' => $p['statut'],
        'poste_pref' => $poste_pref,
        'tit' => $tit,
        'remp' => $remp,
        'moy' => $moy !== null ? round($moy,2) : null,
        'consec' => $consec,
        'pct' => $pct,
    ];
}
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Statistiques</title>
</head>
<body>
<h2>Résumé matchs</h2>
<ul>
    <li>Victoires: <?php echo htmlspecialchars($tot['Victoire'] ?? 0); ?></li>
    <li>Défaites: <?php echo htmlspecialchars($tot['Défaite'] ?? 0); ?></li>
    <li>Non joués / en attente: <?php echo htmlspecialchars($tot[null] ?? 0); ?></li>
    <li>Total: <?php echo htmlspecialchars($totalMatchs); ?></li>
</ul>

<h2>Stats joueurs</h2>
<table border="1" cellpadding="4">
<tr><th>Joueur</th><th>Statut</th><th>Poste fav.</th><th>Tit.</th><th>Remp.</th><th>Moy. note</th><th>Consécutifs</th><th>% victoires</th></tr>
<?php foreach ($stats as $s): ?>
<tr>
    <td><?php echo htmlspecialchars($s['nom']); ?></td>
    <td><?php echo htmlspecialchars($s['statut']); ?></td>
    <td><?php echo htmlspecialchars($s['poste_pref']); ?></td>
    <td><?php echo htmlspecialchars($s['tit']); ?></td>
    <td><?php echo htmlspecialchars($s['remp']); ?></td>
    <td><?php echo $s['moy'] !== null ? htmlspecialchars($s['moy']) : '-'; ?></td>
    <td><?php echo htmlspecialchars($s['consec']); ?></td>
    <td><?php echo $s['pct'] !== null ? htmlspecialchars($s['pct']).'%' : '-'; ?></td>
</tr>
<?php endforeach; ?>
</table>

<form action="accueil.php" method="get"><button type="submit">Accueil</button></form>
</body></html>