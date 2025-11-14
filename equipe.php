<?php
try {
    $linkpdo = new PDO("mysql:localhost;basketball", 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$req = $linkpdo->prepare('SELECT * FROM joueur');
?>
    <table border="1" cellpadding="5" cellspacing="0">';
    <tr>
    <th>Numéro de Licence</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Date de naissance</th>
    <th>Taille</th>
    <th>Poids</th>
    <th>Statut</th>
    <th>Commentaire</th>
    <th>Modification/Supression</th>
    </tr>;
<?php
    while ($data = $req->fetch()) {
        echo '<tr>';
        echo '<td>' . $data['num_licence'] . '</td>';
        echo '<td>' . $data['nom'] . '</td>';
        echo '<td>' . $data['prenom'] . '</td>';
        echo '<td>' . $data['date_naissance'] . '</td>';
        echo '<td>' . $data['taille'] . '</td>';
        echo '<td>' . $data['poids'] . '</td>';
        echo '<td>' . $data['statut'] . '</td>';
        echo '<td>' . $data['commentaire'] . '</td>';
        echo '<td>
                <a href="modificationjoueur.php?var1=' . $data['id'] . '">Modifier</a> |
                <a href="suppressionjoueur.php?var1=' . $data['id'] . '">Supprimer</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';

    $req->closeCursor();
?>