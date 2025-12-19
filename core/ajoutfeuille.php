<?php
try {
    $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur BDD');
}

if (!empty($_POST)) {
    $id_match = (int)($_POST['id_match'] ?? 0);
    $entrees = [];
    for ($i=0;$i<50;$i++) {
        if (!isset($_POST["player_$i"])) break;
        $num = $_POST["player_$i"];
        if ($num === '') continue;
        $entrees[] = ['num' => $num, 'role' => $_POST["role_$i"] ?? 'Remplaçant', 'poste' => $_POST["poste_$i"] ?? ''];
    }

    if ($id_match && count($entrees)) {
        $linkpdo->beginTransaction();
        try {
            $del = $linkpdo->prepare('DELETE FROM feuille_match WHERE id_match = ?');
            $del->execute([$id_match]);
            $ins = $linkpdo->prepare('INSERT INTO feuille_match (id_match, num_licence, role, poste, note) VALUES (?, ?, ?, ?, NULL)');
            foreach ($entrees as $e) {
                $ins->execute([$id_match, $e['num'], $e['role'], $e['poste']]);
            }
            $linkpdo->commit();
        } catch (Exception $ex) {
            $linkpdo->rollBack();
        }
    }
}

header('Location: ../pages/accueil.php');
exit;
?>