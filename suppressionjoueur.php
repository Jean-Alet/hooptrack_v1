<?php
if (isset($_GET['var1'])) {
    $num_licence = $_GET['var1'];
    if (isset($_POST['submit2'])) {
        try {
            $linkpdo = new PDO("mysql:localhost;basketball", 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $delete = $linkpdo->prepare('DELETE * FROM joueur WHERE num_licence = :num_licence');
        $delete->execute(['num_licence' => $num_licence]);
        exit;
    }
} else {
    die("Aucun contact sélectionné.");
}

if (isset($_POST['submit1'])) {
    header('Location: equipe.php');
    exit;
}
?>
<form method="post">
    <input type="submit" name="submit1" value="Retour">
    <input type="submit" name="submit2" value="Valider Suppression">
</form>