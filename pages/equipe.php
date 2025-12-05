<?php
try {
    $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include '../includes/_nav.php';

$req = $linkpdo->prepare('SELECT num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires FROM joueur ORDER BY nom, prenom');
$req->execute();
?>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<table>
<tr>
    <th>Numéro de Licence</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Date de naissance</th>
    <th>Taille</th>
    <th>Poids</th>
    <th>Statut</th>
    <th>Commentaire</th>
    <th>Modification/Suppression</th>
</tr>
<?php
while ($data = $req->fetch()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($data['num_licence']) . '</td>';
    echo '<td>' . htmlspecialchars($data['nom']) . '</td>';
    echo '<td>' . htmlspecialchars($data['prenom']) . '</td>';
    echo '<td>' . htmlspecialchars($data['date_naissance']) . '</td>';
    echo '<td>' . htmlspecialchars($data['taille']) . '</td>';
    echo '<td>' . htmlspecialchars($data['poids']) . '</td>';
    echo '<td>' . htmlspecialchars($data['statut']) . '</td>';
    echo '<td>' . htmlspecialchars($data['commentaires']) . '</td>';
    echo '<td><a href="../core/modificationjoueur.php?var1=' . urlencode($data['num_licence']) . '">Modifier</a> | <a href="../core/suppressionjoueur.php?var1=' . urlencode($data['num_licence']) . '">Supprimer</a></td>';
    echo '</tr>';
}

$req->closeCursor();
?>
</table>

<form action="../pages/ajouterjoueur.php" method="get">
    <button type="submit">Ajouter joueur</button>
</form>

<form action="accueil.php" method="get">
    <button type="submit">Accueil</button>
</form>
</body>