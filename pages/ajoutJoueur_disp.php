<?php include '../includes/_session.php'; 
        include '../includes/_nav.php'; ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter joueur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Ajouter un joueur</h2>

<form method="post" action="../core/ajoutjoueur.php">

    Numéro licence :
    <input type="text" name="num_licence" required><br>

    Nom :
    <input type="text" name="nom" required><br>

    Prénom :
    <input type="text" name="prenom" required><br>

    Date de naissance :
    <input type="date" name="date_naissance" required><br>

    Taille (cm) :
    <input type="number" name="taille"><br>

    Poids (kg) :
    <input type="number" name="poids"><br>

    Statut :
    <select name="statut">
        <option>Actif</option>
        <option>Inactif</option>
        <option>Blessé</option>
    </select><br>

    Commentaire :
    <textarea name="commentaire"></textarea><br>

    <input type="submit" value="Ajouter">
</form>

<form action="equipe.php" method="get">
    <button type="submit">Retour</button>
</form>

</body>
</html>