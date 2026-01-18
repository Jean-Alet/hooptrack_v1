<?php
include '../includes/_session.php';
include '../includes/_modifierfeuille.php';

// Récupérer les détails du joueur si demandé
$joueur_details = null;
if (isset($_GET['joueur_id'])) {
    $joueur_details = getJoueurById($linkpdo, $_GET['joueur_id']);
}

// Calculer le nombre de titulaires et remplaçants sélectionnés
$nb_titulaires = 0;
$nb_remplacants = 0;
if ($use_post_data) {
    for ($i = 0; $i < 12; $i++) {
        $joueur = $post_data["joueur_$i"] ?? '';
        $role = $post_data["role_$i"] ?? 'Titulaire';
        if (!empty($joueur)) {
            if ($role === 'Titulaire') {
                $nb_titulaires++;
            } else {
                $nb_remplacants++;
            }
        }
    }
} else {
    foreach ($feuille as $e) {
        if ($e['role'] === 'Titulaire') {
            $nb_titulaires++;
        } else {
            $nb_remplacants++;
        }
    }
}
?>
<!doctype html>
<html><head>
    <title>Modifier feuille de match</title>
    <?php include '../includes/_head.php'; ?>
</head>
<body>
<?php include '../includes/_nav.php'; ?>

<div class="container">
    <h2>Modifier feuille de match</h2>
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
        <a href="modifierFeuilleMatch_disp.php?match_id=<?php echo $match['id_match']; ?>">Retour</a>
    <?php endif; ?>
    
    <div class="match-info">
        <h3><?php echo htmlspecialchars($match['date_match'] . ' - ' . $match['equipe_adverse'] . ' (' . $match['lieu'] . ')'); ?></h3>
    </div>

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
        <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
        
        <div class="selection-summary">
            <strong>Résumé de la sélection :</strong>
            Titulaires sélectionnés : <span class="badge"><?php echo $nb_titulaires; ?>/5</span> | 
            Remplaçants sélectionnés : <span class="badge"><?php echo $nb_remplacants; ?></span>
            <?php if ($nb_titulaires < 5): ?>
                <span class="warning">(⚠️ Minimum 5 titulaires requis)</span>
            <?php endif; ?>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                    <th>Détails</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Si erreur précédente, utiliser les POST data, sinon utiliser la feuille actuelle
                $items_to_display = $use_post_data ? 12 : (count($feuille) + 5);
                
                for ($i = 0; $i < $items_to_display; $i++):
                    if ($use_post_data) {
                        // Récupérer depuis POST data sauvegardées
                        $selected_joueur = $post_data["joueur_$i"] ?? '';
                        $selected_role = $post_data["role_$i"] ?? 'Titulaire';
                        $selected_poste = $post_data["poste_$i"] ?? 'Meneur';
                        $joueur_existant = false;
                    } else {
                        // Si dans les limites de la feuille actuelle
                        if ($i < count($feuille)) {
                            $e = $feuille[$i];
                            $selected_joueur = $e['num_licence'];
                            $selected_role = $e['role'];
                            $selected_poste = $e['poste'];
                            $joueur_existant = true;
                            $nom_prenom = $e['nom'] . ' ' . $e['prenom'];
                        } else {
                            $selected_joueur = '';
                            $selected_role = 'Titulaire';
                            $selected_poste = 'Meneur';
                            $joueur_existant = false;
                        }
                    }
                ?>
                    <tr>
                        <?php if ($use_post_data || !$joueur_existant): ?>
                            <!-- Mode édition: select pour le joueur -->
                            <td>
                                <select name="joueur_<?php echo $i; ?>">
                                    <option value="">-- joueur --</option>
                                    <?php foreach ($joueurs as $j): ?>
                                        <option value="<?php echo htmlspecialchars($j['num_licence']); ?>" <?php if ($j['num_licence'] === $selected_joueur) echo 'selected'; ?>><?php echo htmlspecialchars($j['nom'].' '.$j['prenom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        <?php else: ?>
                            <!-- Mode affichage: nom du joueur -->
                            <td><?php echo htmlspecialchars($nom_prenom); ?></td>
                            <input type="hidden" name="joueur_<?php echo $i; ?>" value="<?php echo htmlspecialchars($selected_joueur); ?>">
                        <?php endif; ?>
                        
                        <td>
                            <select name="role_<?php echo $i; ?>">
                                <option value="Titulaire" <?php if ($selected_role == 'Titulaire') echo 'selected'; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php if ($selected_role == 'Remplaçant') echo 'selected'; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <select name="poste_<?php echo $i; ?>">
                                <option value="Meneur" <?php if ($selected_poste == 'Meneur') echo 'selected'; ?>>Meneur</option>
                                <option value="Arrière" <?php if ($selected_poste == 'Arrière') echo 'selected'; ?>>Arrière</option>
                                <option value="Ailier" <?php if ($selected_poste == 'Ailier') echo 'selected'; ?>>Ailier</option>
                                <option value="Ailier fort" <?php if ($selected_poste == 'Ailier fort') echo 'selected'; ?>>Ailier fort</option>
                                <option value="Pivot" <?php if ($selected_poste == 'Pivot') echo 'selected'; ?>>Pivot</option>
                            </select>
                        </td>
                        <td>
                            <?php if (!empty($selected_joueur)): ?>
                                <a href="?match_id=<?php echo $match['id_match']; ?>&joueur_id=<?php echo htmlspecialchars($selected_joueur); ?>" class="btn-small">Voir détails</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($joueur_existant && !$use_post_data): ?>
                                <a href="../core/retirerJoueur.php?match_id=<?php echo $match['id_match']; ?>&joueur_id=<?php echo htmlspecialchars($selected_joueur); ?>">Retirer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="actions">
            <input type="submit" value="Mettre à jour feuille">
        </div>
    </form>
    
    <form action="feuille_match_disp.php" method="get">
        <div class="actions">
            <button type="submit">Retour</button>
        </div>
    </form>
</div>
</body></html>