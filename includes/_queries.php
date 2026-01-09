<?php
function getMatchFutur($linkpdo) {
    $stm = $linkpdo->prepare('SELECT id_match, date_match, equipe_adverse FROM `match` WHERE date_match >= NOW() ORDER BY date_match ASC');
    $stm->execute();
    return $stm->fetchAll();
}

function getMatch($linkpdo){
    $req = $linkpdo->prepare('SELECT id_match, date_match, equipe_adverse, lieu, resultat FROM `match` ORDER BY date_match DESC');
    $req->execute();
    return $req->fetchAll();
}

function getMatchById($linkpdo, $id) {
    $sel = $linkpdo->prepare('SELECT id_match, date_match, equipe_adverse, lieu, resultat FROM `match` WHERE id_match = ?');
    $sel->execute([$id]);
    return $sel->fetch();
}

function getJoueurById($linkpdo, $num) {
    $sel = $linkpdo->prepare('SELECT num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires FROM joueur WHERE num_licence = ?');
    $sel->execute([$num]);
    return $sel->fetch();
}

function insertMatch($linkpdo, $date, $adv, $lieu, $resultat) {
    $req = $linkpdo->prepare('INSERT INTO `match` (date_match, equipe_adverse, lieu, resultat) VALUES (?, ?, ?, ?)');
    $req->execute([$date, $adv, $lieu, $resultat]);
}

function updateMatch($linkpdo, $id, $date, $equipe, $lieu, $resultat) {
    $maj = $linkpdo->prepare('UPDATE `match` SET date_match = ?, equipe_adverse = ?, lieu = ?, resultat = ? WHERE id_match = ?');
    $maj->execute([$date, $equipe, $lieu, $resultat === '' ? null : $resultat, $id]);
}

function deleteMatch($linkpdo, $id) {
    $sup = $linkpdo->prepare('DELETE FROM `match` WHERE id_match = ?');
    $sup->execute([$id]);
}

function getResultatMatch($linkpdo) {
    $stmt = $linkpdo->query("SELECT resultat, COUNT(*) as c FROM `match` GROUP BY resultat");
    return $stmt->fetchAll();
}

function getIdsMatch($linkpdo) {
    return array_column(getMatch($linkpdo), 'id_match');
}

function getIdsMatchPasses($linkpdo) {
    $req = $linkpdo->prepare('SELECT id_match FROM `match` WHERE date_match < NOW() ORDER BY date_match DESC');
    $req->execute();
    return $req->fetchAll(PDO::FETCH_COLUMN);
}

// Player queries
function getJoueur($linkpdo) {
    $req = $linkpdo->prepare('SELECT num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires FROM joueur ORDER BY nom, prenom');
    $req->execute();
    return $req->fetchAll();
}

function getJoueurActif($linkpdo) {
    $stm2 = $linkpdo->prepare('SELECT num_licence, nom, prenom FROM joueur WHERE statut = "Actif" ORDER BY nom, prenom');
    $stm2->execute();
    return $stm2->fetchAll();
}


function insertJoueur($linkpdo, $num, $nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaire) {
    $req = $linkpdo->prepare('INSERT INTO joueur (num_licence, nom, prenom, date_naissance, taille, poids, statut, commentaires) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $req->execute([$num, $nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaire]);
}

function updateJoueur($linkpdo, $id, $nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaires) {
    $req = $linkpdo->prepare('UPDATE joueur SET nom = ?, prenom = ?, date_naissance = ?, taille = ?, poids = ?, statut = ?, commentaires = ? WHERE num_licence = ?');
    $req->execute([$nom, $prenom, $date_naiss, $taille, $poids, $statut, $commentaires, $id]);
}

function deleteJoueur($linkpdo, $num) {
    $sup = $linkpdo->prepare('DELETE FROM joueur WHERE num_licence = ?');
    $sup->execute([$num]);
}


// Feuille match queries
function FeuilleExiste($linkpdo, $id_match) {
    $check = $linkpdo->prepare('SELECT COUNT(*) FROM feuille_match WHERE id_match = ?');
    $check->execute([$id_match]);
    return $check->fetchColumn() > 0;
}

function deleteFeuille($linkpdo, $id_match) {
    $del = $linkpdo->prepare('DELETE FROM feuille_match WHERE id_match = ?');
    $del->execute([$id_match]);
}

function insertFeuille($linkpdo, $id_match, $num, $role, $poste) {
    $ins = $linkpdo->prepare('INSERT INTO feuille_match (id_match, num_licence, role, poste, note) VALUES (?, ?, ?, ?, NULL)');
    $ins->execute([$id_match, $num, $role, $poste]);
}

function getNbTitulaire($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE num_licence = ? AND role = 'Titulaire'");
    $q->execute([$num]);
    return (int)$q->fetchColumn();
}

function getNbRemplacant($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE num_licence = ? AND role = 'Remplaçant'");
    $q->execute([$num]);
    return (int)$q->fetchColumn();
}

function getMoyenneNote($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT AVG(note) FROM feuille_match WHERE num_licence = ? AND note IS NOT NULL");
    $q->execute([$num]);
    return $q->fetchColumn();
}

function getPosteFavori($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT poste, COUNT(*) as c FROM feuille_match WHERE num_licence = ? GROUP BY poste ORDER BY c DESC LIMIT 1");
    $q->execute([$num]);
    return $q->fetch();
}

function getResultatJoueur($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT m.resultat FROM feuille_match f JOIN `match` m ON f.id_match = m.id_match WHERE f.num_licence = ?");
    $q->execute([$num]);
    return $q->fetchAll(PDO::FETCH_COLUMN);
}

function estDansMatch($linkpdo, $mid, $num) {
    $q2 = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE id_match = ? AND num_licence = ?");
    $q2->execute([$mid, $num]);
    return $q2->fetchColumn() > 0;
}

function aDejaJoue($linkpdo, $num) {
    $q = $linkpdo->prepare("SELECT COUNT(*) FROM feuille_match WHERE num_licence = ?");
    $q->execute([$num]);
    return $q->fetchColumn() > 0;
}

// Auth queries
function PasswordHash($linkpdo, $login) {
    $requete = $linkpdo->prepare('SELECT mdp_hash FROM utilisateur WHERE login_utilisateur = ?');
    $requete->execute([$login]);
    return $requete->fetchColumn();
}

// Special queries

function getFeuilleParMatch($linkpdo, $id_match) {
    $q = $linkpdo->prepare("SELECT f.num_licence, j.nom, j.prenom, f.role, f.poste, f.note FROM feuille_match f JOIN joueur j ON f.num_licence = j.num_licence WHERE f.id_match = ? ORDER BY f.role DESC, j.nom, j.prenom");
    $q->execute([$id_match]);
    return $q->fetchAll();
}

function getMatchLienFeuille($linkpdo) {
    $q = $linkpdo->prepare("SELECT DISTINCT m.id_match, m.date_match, m.equipe_adverse, m.lieu, m.resultat FROM `match` m JOIN feuille_match f ON m.id_match = f.id_match ORDER BY m.date_match DESC");
    $q->execute();
    return $q->fetchAll();
}

// Utility function for date formatting
function formatDateFr($date) {
    if (empty($date)) return '';
    $datetime = new DateTime($date);
    return $datetime->format('d-m-Y H:i:s');
}

?>