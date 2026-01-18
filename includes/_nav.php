<nav>
    <a href="../pages/accueil_disp.php" class="btn"><div class="logo">
        <img src="../css/logo.svg" alt="Logo Basketball">
    </div></a>
    <a href="../pages/accueil_disp.php" class="btn"> Accueil</a>
    <a href="../pages/equipe_disp.php" class="btn"> Joueurs</a>
    <a href="../pages/match_disp.php" class="btn"> Matchs</a>
    <a href="../pages/feuille_match_disp.php" class="btn"> Feuilles de match</a>
    <a href="../pages/statistiques_disp.php" class="btn"> Statistiques</a>
    <a href="../core/déconnecter.php" class="btn">Déconnexion</a>
    <span class="user-info">Connecté : <?php echo htmlspecialchars($_SESSION['login']); ?></span>
</nav>