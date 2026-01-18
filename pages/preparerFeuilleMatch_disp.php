<?php
include '../includes/_session.php';
include '../includes/_feuillematch.php';

// Récupérer les détails du joueur si demandé
$joueur_details = null;
if (isset($_GET['joueur_id'])) {
    $joueur_details = getJoueurById($linkpdo, $_GET['joueur_id']);
}

// Calculer le nombre de titulaires et remplaçants sélectionnés
$nb_titulaires = 0;
$nb_remplacants = 0;
$postes_titulaires = [];
for ($i = 0; $i < 12; $i++) {
    $joueur = $_POST["joueur_$i"] ?? ($_SESSION['post_data']["joueur_$i"] ?? '');
    $role = $_POST["role_$i"] ?? ($_SESSION['post_data']["role_$i"] ?? 'Titulaire');
    if (!empty($joueur)) {
        if ($role === 'Titulaire') {
            $nb_titulaires++;
            $poste = $_POST["poste_$i"] ?? ($_SESSION['post_data']["poste_$i"] ?? '');
            $postes_titulaires[] = $poste;
        } else {
            $nb_remplacants++;
        }
    }
}
?>
<!doctype html>
<html><head>
    <title>Préparer feuille de match</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Préparer feuille de match</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Affichage des détails du joueur si demandé -->
    <?php if ($joueur_details): ?>
        <?php include '../includes/_joueurdetails.php'; ?>
        <a href="preparerFeuilleMatch_disp.php">Retour</a>
    <?php endif; ?>

    <div class="conditions">
        <h3>Conditions de sélection :</h3>
        <ul>
            <li><strong>5 joueurs titulaires</strong> - 1 par poste</li>
            <li><strong>Postes requis :</strong> Meneur, Arrière, Ailier, Ailier fort, Pivot</li>
            <li><strong>Remplaçants :</strong> Sélection libre du nombre de remplaçants</li>
            <li><strong>Joueurs uniques :</strong> Aucun joueur ne peut être sélectionné plusieurs fois</li>
        </ul>
    </div>

    <form method="post" action="../core/ajoutfeuille.php">
        <label>Match:</label>
        <select name="id_match" required>
            <?php foreach ($matchs as $m): ?>
                <option value="<?php echo $m['id_match']; ?>"><?php echo htmlspecialchars(formatDateFr($m['date_match']).' - '.$m['equipe_adverse']); ?></option>
            <?php endforeach; ?>
        </select>

        <div class="selection-summary">
            <strong>Résumé de la sélection :</strong>
            Titulaires sélectionnés : <span class="badge"><?php echo $nb_titulaires; ?>/5</span> | 
            Remplaçants sélectionnés : <span class="badge"><?php echo $nb_remplacants; ?></span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i=0;$i<12;$i++): 
                    // Récupérer les valeurs POST précédentes en cas d'erreur
                    $selected_joueur = $_POST["joueur_$i"] ?? ($_SESSION['post_data']["joueur_$i"] ?? '');
                    $selected_role = $_POST["role_$i"] ?? ($_SESSION['post_data']["role_$i"] ?? 'Titulaire');
                    $selected_poste = $_POST["poste_$i"] ?? ($_SESSION['post_data']["poste_$i"] ?? 'Meneur');
                    
                    // Nettoyer les données de session après utilisation
                    if (!empty($_SESSION['post_data'])) {
                        unset($_SESSION['post_data']);
                    }
                ?>
                    <tr>
                        <td>
                            <select name="joueur_<?php echo $i; ?>" class="joueur-select">
                                <option value="">-- joueur --</option>
                                <?php foreach ($joueurs as $j): ?>
                                    <option value="<?php echo htmlspecialchars($j['num_licence']); ?>" <?php if ($j['num_licence'] === $selected_joueur) echo 'selected'; ?>><?php echo htmlspecialchars($j['nom'].' '.$j['prenom']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="role_<?php echo $i; ?>" class="role-select">
                                <option value="Titulaire" <?php if ($selected_role === 'Titulaire') echo 'selected'; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php if ($selected_role === 'Remplaçant') echo 'selected'; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <select name="poste_<?php echo $i; ?>" class="poste-select">
                                <option <?php if ($selected_poste === 'Meneur') echo 'selected'; ?>>Meneur</option>
                                <option <?php if ($selected_poste === 'Arrière') echo 'selected'; ?>>Arrière</option>
                                <option <?php if ($selected_poste === 'Ailier') echo 'selected'; ?>>Ailier</option>
                                <option <?php if ($selected_poste === 'Ailier fort') echo 'selected'; ?>>Ailier fort</option>
                                <option <?php if ($selected_poste === 'Pivot') echo 'selected'; ?>>Pivot</option>
                            </select>
                        </td>
                        <td>
                            <?php if (!empty($selected_joueur)): ?>
                                <a href="?joueur_id=<?php echo htmlspecialchars($selected_joueur); ?>" class="btn-small">Voir détails</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="actions">
            <input type="submit" value="Enregistrer feuille">
        </div>
    </form>
    <form action="accueil_disp.php" method="get">
        <div class="actions">
            <button type="submit">Accueil</button>
        </div>
    </form>
</div>
</body></html>