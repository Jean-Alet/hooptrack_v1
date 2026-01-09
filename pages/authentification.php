<?php
session_start();
$error = '';
$login = isset($_POST['login']) ? $_POST['login'] : '';
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';

if (!empty($_POST)) {
    if ($login === '' || $mdp === '') { 
        $error = 'Remplissez tous les champs.';
    } else {
        try {
            $linkpdo = new PDO('mysql:host=localhost;dbname=basketball', 'root', '');
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // pour gerer les exceptions (plus propre)
        } catch (Exception $e) {
            die('Erreur BDD');
        }

        $requete = $linkpdo->prepare('SELECT mdp_hash FROM utilisateur WHERE login_utilisateur = ?');
        $requete->execute([$login]);
        $mdphash = $requete->fetchColumn(); // pour recuperer le hash ou false (fetch de base ne fonctionne pas dans ce cas)

        if ($mdphash === false) {
            $error = 'Utilisateur introuvable.';
        } elseif (!password_verify($mdp, $mdphash)) {
            $error = 'Mot de passe incorrect.';
        } else {
            $_SESSION['login'] = $login;
            header('Location: accueil.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Authentification</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php if ($error): ?>
        <p><?php echo htmlspecialchars($error); ?></p> 
    <?php endif; ?>

    <form action="" method="post">
        Login : <input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>">
        Mot de passe : <input type="password" name="mdp">
        <input type="submit" value="Envoyer">
    </form>
    <br />
</body>
</html>