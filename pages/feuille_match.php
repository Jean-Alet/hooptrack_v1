<?php include '../includes/_nav.php';
        include '../includes/_linkpdo.php';

$matchs = $linkpdo->query(
    "SELECT id_match, date_match, equipe_adverse
     FROM `match`
     WHERE date_match >= NOW()
     ORDER BY date_match ASC"
)->fetchAll(PDO::FETCH_ASSOC);

$joueurs = $linkpdo->query(
    "SELECT num_licence, nom, prenom, taille, poids, commentaires
     FROM joueur
     WHERE statut='Actif'
     ORDER BY nom, prenom"
)->fetchAll(PDO::FETCH_ASSOC);

$id_match = $_GET['id_match'] ?? $_POST['id_match'] ?? null;

$feuille = [];
if ($id_match && empty($_POST)) {
    $stm = $linkpdo->prepare(
        "SELECT num_licence, role, poste, note
         FROM feuille_match
         WHERE id_match = ?"
    );
    $stm->execute([$id_match]);
    $feuille = $stm->fetchAll(PDO::FETCH_ASSOC);
}

$source = [];
if (!empty($_POST)) {
    for ($i = 0; $i < 12; $i++) {
        if (!isset($_POST["player_$i"])) break;
        if ($_POST["player_$i"] === '') continue;
        $source[] = [
            'num_licence' => $_POST["player_$i"],
            'role'        => $_POST["role_$i"],
            'poste'       => $_POST["poste_$i"]
        ];
    }
} else {
    $source = $feuille;
}

$joueursIndex = [];
foreach ($joueurs as $j) {
    $joueursIndex[$j['num_licence']] = $j;
}

$error = $error ?? null;
$postes = ['Meneur', 'Arrière', 'Ailier', 'Ailier fort', 'Pivot'];
$max = max(12, count($source));
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Feuille de match</title>
</head>
<body>

<h3>Feuille de match</h3>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="get">
    <select name="id_match" onchange="this.form.submit()">
        <option value="">-- match --</option>
        <?php foreach ($matchs as $m): ?>
            <option value="<?= $m['id_match'] ?>" <?= ($id_match == $m['id_match']) ? 'selected' : '' ?>>
                <?= $m['date_match'] . ' ' . $m['equipe_adverse'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($id_match): ?>
<form method="post" action="../core/ajoutFeuille.php">
    <input type="hidden" name="id_match" value="<?= $id_match ?>">

    <table border="1">
        <tr>
            <th>Joueur</th>
            <th>Rôle</th>
            <th>Poste</th>
            <th>Note</th>
            <th>Commentaires</th>
        </tr>
        <?php for ($i = 0; $i < $max; $i++):
            $f = $source[$i] ?? null;
            $j = $f ? $joueursIndex[$f['num_licence']] ?? null : null;
        ?>
        <tr>
            <td>
                <select name="player_<?= $i ?>">
                    <option value="">-- joueur --</option>
                    <?php foreach ($joueurs as $joueur): ?>
                        <option value="<?= $joueur['num_licence'] ?>" <?= ($f && $f['num_licence'] == $joueur['num_licence']) ? 'selected' : '' ?>>
                            <?= $joueur['nom'] . ' ' . $joueur['prenom'] . ' - ' . $joueur['taille'] . 'cm/' . $joueur['poids'] . 'kg' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>

            <td>
                <?php
                $titulaire_deja = array_column(array_filter($source, fn($e) => $e['role'] == 'Titulaire'), 'poste');
                ?>
                <select name="role_<?= $i ?>">
                    <option value="Titulaire" <?= ($f && $f['role'] == 'Titulaire') ? 'selected' : '' ?> <?= ($f && in_array($f['poste'], $titulaire_deja) && $f['role'] != 'Titulaire') ? 'disabled' : '' ?>>Titulaire</option>
                    <option value="Remplaçant" <?= ($f && $f['role'] == 'Remplaçant') ? 'selected' : '' ?>>Remplaçant</option>
                </select>
            </td>

            <td>
                <select name="poste_<?= $i ?>">
                    <?php foreach ($postes as $p): ?>
                        <option value="<?= $p ?>" <?= ($f && $f['poste'] == $p) ? 'selected' : '' ?>><?= $p ?></option>
                    <?php endforeach; ?>
                </select>
            </td>

            <td>
                <?= $f['note'] ?? '' ?>
            </td>

            <td>
                <?= $j['commentaires'] ?? '' ?>
            </td>
        </tr>
        <?php endfor; ?>
    </table>

    <br>
    <input type="submit" value="Enregistrer">
</form>
<?php endif; ?>

</body>
</html>