<?php include '../includes/_session.php'; 
      include '../includes/_nav.php'; ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Ajouter un match</h2>

    <form method="post" action="../core/ajoutmatch.php">

        <label>Date et heure :</label>
        <input type="datetime-local" name="date_match" required>

        <label>Équipe adverse :</label>
        <input type="text" name="equipe_adverse" required>

        <label>Lieu :</label>
        <select name="lieu">
            <option>Domicile</option>
            <option>Extérieur</option>
        </select>

        <label>Résultat :</label>
        <select name="resultat">
            <option value="">--</option>
            <option>Victoire</option>
            <option>Défaite</option>
        </select>

        <div class="actions">
            <input type="submit" value="Ajouter">
        </div>
    </form>

    <form action="match_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>

</body>
</html>