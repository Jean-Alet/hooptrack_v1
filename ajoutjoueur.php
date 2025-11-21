<?php
try {
    $linkpdo = new PDO("mysql:host=localhost;dbname=basketball", 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['num_licence', 'nom', 'prenom', 'date_naissance', 'taille', 'poids', 'statut', 'commentaires'];
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
        'INSERT INTO joueur(num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires) 
        VALUES(:num_licence, :nom, :prenom, :date_naissance, :taille, :poids, :statut, :commentaires)');

    $req->execute([
        'num_licence' => $_POST['num_licence'],
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'date_naissance' => $_POST['date_naissance'],
        'taille' => $_POST['taille'],
        'poids' => $_POST['poids'],
        'statut' => $_POST['statut'],
        'commentaires' => $_POST['commentaires']
    ]);
}
?>
<form method="post" action="ajoutjoueur.php">

    <label>Numéro de licence :</label><br>
    <input type="text" name="num_licence" required><br><br>

    <label>Nom :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Prénom :</label><br>
    <input type="text" name="prenom" required><br><br>

    <label>Date de naissance :</label><br>
    <input type="date" name="date_naissance" required><br><br>

    <label>Taille (en cm) :</label><br>
    <input type="number" step="0.1" name="taille" required><br><br>

    <label>Poids (en kg) :</label><br>
    <input type="number" step="0.01" name="poids" required><br><br>

    <label>Statut :</label><br>
    <select name="statut" required>
        <option value="Actif">Actif</option>
        <option value="Blessé">Blessé</option>
        <option value="Suspendu">Suspendu</option>
        <option value="Absent">Absent</option>
    </select><br><br>

    <label>Commentaires :</label><br>
    <textarea name="commentaires" required></textarea><br><br>

    <button type="submit">Ajouter le joueur</button>

</form>
