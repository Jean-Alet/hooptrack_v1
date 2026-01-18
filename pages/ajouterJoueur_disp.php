<?php include '../includes/_session.php'; ?>

<!doctype html>
<html>
<head>
    <title>Ajouter un joueur</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Ajouter un joueur</h2>

    <form method="post" action="../core/ajoutjoueur.php">

        <label>Numéro licence :</label>
        <input type="text" name="num_licence" required>

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" required>

        <label>Taille (cm) :</label>
        <input type="number" name="taille">

        <label>Poids (kg) :</label>
        <input type="number" name="poids">

        <label>Nationalité :</label>
        <input type="text" name="nationalite" placeholder="ex: France">

        <label>Statut :</label>
        <select name="statut">
            <option>Actif</option>
            <option>Inactif</option>
            <option>Blessé</option>
        </select>

        <label>Commentaires :</label>
        <textarea name="commentaire"></textarea>

        <div class="actions">
            <input type="submit" value="Ajouter">
        </div>
    </form>

    <form action="equipe_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>

</body>
</html>