<?php
try {
    $linkpdo = new PDO("mysql:localhost;basketball", 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$fields = ['num_licence', 'nom', 'prenom', 'date_naissance', 'taille', 'poids', 'statut', 'commmentaire'];
foreach ($fields as $field) {
    if (!isset($_POST[$field])) {
        die('Champ manquant : ' . $field);
    }
}

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $delete = $linkpdo->prepare('DELETE FROM sinj WHERE id = :id');
    $delete->execute(['id' => $_POST['id']]);
}

$req = $linkpdo->prepare(
    'INSERT INTO joueur(num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaire) 
    VALUES(:num_licence, :nom, :prenom, :date_naissance, :taille, :poids, :statut, :commentaire)');

$req->execute([
    'num_licence' => $_POST['num_licence'],
    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'date_naissance' => $_POST['date_naissance'],
    'taille' => $_POST['taille'],
    'poids' => $_POST['poids'],
    'statut' => $_POST['statut'],
    'commentaire' => $_POST['commentaire']
]);
?>