<?php
try {
    $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur BDD');
}

if (!empty($_POST)) {

    $num = $_POST['num_licence'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naiss = $_POST['date_naissance'];
    $taille = $_POST['taille'] ?: null;
    $poids = $_POST['poids'] ?: null;
    $statut = $_POST['statut'];
    $commentaire = $_POST['commentaire'] ?? '';

    $req = $linkpdo->prepare(
        'INSERT INTO joueur (num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $req->execute([$num, $nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaire]);
}

header('Location: ../pages/equipe.php');
exit;