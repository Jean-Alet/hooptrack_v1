<?php

try {
    $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur BDD');
}

include '../includes/_nav.php';

// matchs à venir 
$stm = $linkpdo->prepare('SELECT id_match, date_match, equipe_adverse FROM `match` WHERE date_match >= NOW() ORDER BY date_match ASC');
$stm->execute();
$matchs = $stm->fetchAll(PDO::FETCH_ASSOC);

// joueurs actifs
$stm2 = $linkpdo->prepare('SELECT num_licence, nom, prenom FROM joueur WHERE statut = "Actif" ORDER BY nom, prenom');
$stm2->execute();
$joueurs = $stm2->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Préparer feuille de match</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<form method="post" action="ajoutfeuille.php">
    Match:
    <select name="id_match" required>
        <?php foreach ($matchs as $m): ?>
            <option value="<?php echo $m['id_match']; ?>"><?php echo htmlspecialchars($m['date_match'].' - '.$m['equipe_adverse']); ?></option>
        <?php endforeach; ?>
    </select><br>

    <?php for ($i=0;$i<12;$i++): ?>
        <div>
            <select name="player_<?php echo $i; ?>">
                <option value="">-- joueur --</option>
                <?php foreach ($joueurs as $j): ?>
                    <option value="<?php echo htmlspecialchars($j['num_licence']); ?>"><?php echo htmlspecialchars($j['nom'].' '.$j['prenom']); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="role_<?php echo $i; ?>">
                <option value="Titulaire">Titulaire</option>
                <option value="Remplaçant">Remplaçant</option>
            </select>
            <select name="poste_<?php echo $i; ?>">
                <option>Meneur</option><option>Arrière</option><option>Ailier</option><option>Ailier fort</option><option>Pivot</option>
            </select>
        </div>
    <?php endfor; ?>

    <input type="submit" value="Enregistrer feuille">
</form>
<form action="accueil.php" method="get"><button type="submit">Accueil</button></form>
</body></html>