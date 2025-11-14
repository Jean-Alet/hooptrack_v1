<?php
try {
    $linkpdo = new PDO("mysql:localhost;basketball", 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
if (!empty($recherche)) {

    $req = $linkpdo->prepare('
        SELECT *
        FROM joueur
    ');
?>
    <table border="1" cellpadding="5" cellspacing="0">';
    <tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Adresse</th>
    <th>Code postal</th>
    <th>Ville</th>
    <th>Téléphone</th>
    <th>Actions</th>
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
                <a href="modification.php?var1=' . $data['id'] . '">Modifier</a> |
                <a href="suppression.php?var1=' . $data['id'] . '">Supprimer</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';

    $req->closeCursor();
}
?>