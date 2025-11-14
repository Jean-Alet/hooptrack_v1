<html>
<head>
    <?php
    try {
        $linkpdo = new PDO("mysql:localhost;basketball", 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $variable = $_GET['var1'];

    $req = $linkpdo->prepare('SELECT * FROM joueur WHERE num_licence = ?');
    $req->execute([$variable]);
    $data = $req->fetch();
    ?>
</head>
<body>
    <form action="http://localhost/ajoutcontact.php" method="post">
        Numéro de Licence : <input type="text" name="num_licence" value="<?php echo htmlspecialchars($data['num_licence']); ?>"><br />
        Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($data['nom']); ?>"><br />
        Prénom : <input type="text" name="prenom" value="<?php echo htmlspecialchars($data['prenom']); ?>"><br />
        Date de naissance : <input type="text" name="date_naissance" value="<?php echo htmlspecialchars($data['date_naissance']); ?>"><br />
        Taille : <input type="text" name="taille" value="<?php echo htmlspecialchars($data['taille']); ?>"><br />
        Poids : <input type="text" name="poids" value="<?php echo htmlspecialchars($data['poids']); ?>"><br />
        Statut : <input type="text" name="statut" value="<?php echo htmlspecialchars($data['statut']); ?>"><br />
        Commentaire : <input type="text" name="commentaire" value="<?php echo htmlspecialchars($data['commentaire']); ?>"><br />

        <input type="hidden" name="num_licence" value="<?php echo $data['num_licence']; ?>">

        <input type="reset" value="Reset" name="reset">
        <input type="submit" value="Valider" name="O">
    </form>
</body>
</html>