<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include '../includes/_nav.php';

$req = $pdo->prepare('SELECT id_match, date_match, equipe_adverse, lieu, resultat FROM `match` ORDER BY date_match DESC');
$req->execute();
?>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
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
while ($row = $req->fetch()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['id_match']) . '</td>';
    echo '<td>' . htmlspecialchars($row['date_match']) . '</td>';
    echo '<td>' . htmlspecialchars($row['equipe_adverse']) . '</td>';
    echo '<td>' . htmlspecialchars($row['lieu']) . '</td>';
    echo '<td>' . htmlspecialchars($row['resultat']) . '</td>';
    echo '<td>'
         . '<a href="../core/modificationmatch.php?var1=' . urlencode($row['id_match']) . '">Modifier</a> | '
         . '<a href="../core/suppressionmatch.php?var1=' . urlencode($row['id_match']) . '">Supprimer</a>'
         . '</td>';
    echo '</tr>';
}
$req->closeCursor();
?>
</table>

<form action="../pages/ajoutermatch.php" method="get">
    <button type="submit">Ajouter match</button>
</form>

<form action="accueil.php" method="get">
    <button type="submit">Accueil</button>
</form>
</body>