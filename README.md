# Gestion de Basketball

Petit projet pour gérer une équipe de basketball : les joueurs, les matchs, les feuilles de match et evaluer les joueurs.

## Fonctionnalités principales

- Gestion des joueurs (ajouter, modifier, supprimer)
- Gestion des matchs (créer des matchs, saisir les résultats)
- Feuilles de match pour tracker la participation
- Système d'évaluation des joueurs
- Authentification simple
- Statistiques basiques

## Structure du projet

core/           - les traitements (ajouter joueur, modifier match, etc)
pages/          - l'affichage des pages (_disp.php c'est l'affichage)
includes/       - les fichiers réutilisables (connexion BD, requêtes, etc)
css/            - le style CSS
data/           - la base de données SQL
img/            - les images

- Quand clic sur un lien, ça va dans une page `*_disp.php`
- La page charge les includes (navigation, head, etc)
- Elle appelle un fichier de `core/` qui traite les données
- Les données viennent de la BD via `_linkpdo.php` et `_queries.php`

## Technologies

- PHP 
- MySQL
- HTML/CSS basique
- PDO pour la BD

## Notes

- Les fichiers d'include commencent par `_` (exemple: `_linkpdo.php`)
- Les fichiers de traitement sont dans `core/`
- Les pages affichage sont dans `pages/` et finissent par `_disp.php`
- Il y a des fichiers en doublon genre `authentification.php` et `authentification_disp.php` - l'un traite, l'autre affiche
- La session est gérée dans `_session.php`