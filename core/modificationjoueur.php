<html>
<head>
    <?php
    try {
        $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
        $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Erreur BDD');
    }

    if (!isset($_GET['var1'])) {
        header('Location: ../pages/equipe.php');
        exit;
    }

$num = $_GET['var1'];

    $req = $linkpdo->prepare('SELECT num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires FROM joueur WHERE num_licence = ?');
    $req->execute([$num]);
    $data = $req->fetch();

if (!$data) {
    header('Location: ../pages/equipe.php');
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Modifier joueur</title>
<link rel="stylesheet" href="../css/style.css"></head>
<body>
    <form action="modificationJoueur.php" method="post">

        Numéro de licence :
        <input type="text" name="num_licence" value="<?php echo htmlspecialchars($data['num_licence']); ?>"><br>

        Nom :
        <input type="text" name="nom" value="<?php echo htmlspecialchars($data['nom']); ?>"><br>

        Prénom :
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($data['prenom']); ?>"><br>

        Date de naissance :
        <input type="date" name="date_naissance" value="<?php echo htmlspecialchars($data['date_naissance']); ?>"><br>

        Taille (cm) :
        <input type="number" name="taille" step="0.1" value="<?php echo htmlspecialchars($data['taille']); ?>"><br>

        Poids (kg) :
        <input type="number" name="poids" step="0.01" value="<?php echo htmlspecialchars($data['poids']); ?>"><br>

        Statut :
        <!-- à changer parce que pas ouf ça fait un peu chatgpt -->
        <select name="statut"><?php  $choix = ['Actif','Blessé','Suspendu','Absent'];
            foreach ($choix as $o) {
                $sel = ($data['statut'] === $o) ? ' selected' : '';
                echo '<option value="'.htmlspecialchars($o).'"'.$sel.'>'.htmlspecialchars($o).'</option>';
            } ?>
        </select><br>

        Commentaires :<br>
        <textarea name="commentaires" rows="4" cols="50"><?php echo htmlspecialchars($data['commentaires']); ?></textarea><br>

    <input type="reset" value="Reset">
    <input type="submit" value="Valider">
</form>

<form action="../pages/equipe.php" method="get"><button type="submit">Retour équipe</button></form>
</body>
</html>