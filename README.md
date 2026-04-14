> **Une version améliorée de ce projet est disponible sur GitHub : [Jean-Alet/hooptrack_v2](https://github.com/Jean-Alet/hooptrack_v2)**  
> Elle repose sur une architecture API REST avec une sécurité renforcée.

# HoopTrack — Gestion d'équipe de basketball

Application web PHP/MySQL pour gérer une équipe de basketball : effectif, matchs, feuilles de match, évaluations et statistiques.

**Démo en ligne :** https://appbasket.infinityfreeapp.com/  
**Identifiants :** login `coach` — mot de passe `basket`

---

## Fonctionnalités

| Module | Ce qu'on peut faire |
|---|---|
| **Joueurs** | Ajouter, modifier, supprimer un joueur ; statuts Actif / Blessé / Suspendu / Absent |
| **Matchs** | Planifier un match, le modifier, le supprimer avant qu'il ait lieu |
| **Feuille de match** | Constituer le groupe, affecter un rôle (Titulaire/Remplaçant) et un poste à chaque joueur |
| **Saisie résultat** | Enregistrer le score, le résultat (Victoire/Défaite) et l'overtime |
| **Évaluations** | Attribuer une note (/10) et un commentaire par joueur après chaque match |
| **Modifier participation** | Changer le rôle ou le poste d'un joueur sur une feuille existante |
| **Statistiques** | Bilan V/D de l'équipe ; par joueur : titularisations, remplacements, moyenne de note, % victoires, matchs consécutifs |
| **Authentification** | Connexion par login/mot de passe (bcrypt), session PHP, déconnexion |

---

## Structure du projet

```
hooptrack/
│
├── index.php                   → redirige vers la page de connexion
│
├── pages/                      → affichage (une page = un fichier *_disp.php)
│   ├── authentification_disp.php
│   ├── accueil_disp.php
│   ├── equipe_disp.php
│   ├── match_disp.php
│   ├── ajouterJoueur_disp.php
│   ├── ajouterMatch_disp.php
│   ├── modifierJoueur_disp.php
│   ├── modifierMatch_disp.php
│   ├── supprimerJoueur_disp.php
│   ├── supprimerMatch_disp.php
│   ├── preparerFeuilleMatch_disp.php
│   ├── feuille_match_disp.php
│   ├── modifierFeuilleMatch_disp.php
│   ├── modifierParticipation_disp.php
│   ├── saisirResultat_disp.php
│   ├── evaluerJoueurs_disp.php
│   └── statistiques_disp.php
│
├── core/                       → traitements POST (un fichier = une action)
│   ├── authentification.php
│   ├── déconnecter.php
│   ├── ajoutjoueur.php
│   ├── ajoutmatch.php
│   ├── modifier_joueur.php
│   ├── modifier_match.php
│   ├── supprimer_joueur.php
│   ├── supprimer_match.php
│   ├── ajoutfeuille.php
│   ├── feuille_match.php
│   ├── retirerJoueur.php
│   ├── modifierParticipation.php
│   ├── saisir_resultat.php
│   ├── enregistrerEvaluations.php
│   ├── enregistrerParticipation.php
│   ├── equipe.php
│   ├── match.php
│   └── statistiques.php
│
├── includes/                   → composants réutilisables (préfixe _)
│   ├── _linkpdo.php            → connexion PDO à la base de données
│   ├── _queries.php            → toutes les fonctions SQL (requêtes préparées)
│   ├── _session.php            → vérification de session (protection des pages)
│   ├── _head.php               → balises <head> HTML communes
│   ├── _nav.php                → barre de navigation
│   ├── _footer.php             → pied de page
│   ├── _error.php              → affichage des messages d'erreur
│   └── _*.php                  → fragments HTML par fonctionnalité
│
├── css/
│   ├── style.css
│   └── logo.svg
│
└── data/
    └── basketball.sql          → dump complet de la base de données
```

### Flux d'une requête

```
Navigateur → pages/*_disp.php  (affichage + formulaire)
                   │
                   └─ POST → core/*.php  (traitement + validation)
                                  │
                                  └─ includes/_queries.php  (SQL via PDO)
                                            │
                                            └─ Base MySQL
```

---

## Base de données

**Nom de la base :** `basketball`

### `joueur`
| Colonne | Type | Description |
|---|---|---|
| `num_licence` | char(8) PK | Identifiant unique du joueur (ex : `LIC00001`) |
| `nom` | varchar(50) | |
| `prenom` | varchar(50) | |
| `date_naissance` | date | |
| `taille` | decimal(4,1) | En cm |
| `poids` | decimal(5,2) | En kg |
| `nationalite` | varchar(50) | |
| `statut` | enum | `Actif`, `Blessé`, `Suspendu`, `Absent` |
| `commentaires` | text | |

### `match`
| Colonne | Type | Description |
|---|---|---|
| `id_match` | int PK auto | |
| `date_match` | datetime | |
| `equipe_adverse` | varchar(50) | |
| `lieu` | enum | `Domicile`, `Extérieur` |
| `resultat` | enum (nullable) | `Victoire`, `Défaite` — null si match non joué |
| `score_equipe` | int (nullable) | |
| `score_adverse` | int (nullable) | |
| `overtime` | tinyint | 1 = prolongation |

### `feuille_match`
| Colonne | Type | Description |
|---|---|---|
| `id_match` | int FK → match | |
| `num_licence` | char(8) FK → joueur | |
| `role` | enum | `Titulaire`, `Remplaçant` |
| `poste` | enum | `Meneur`, `Arrière`, `Ailier`, `Ailier fort`, `Pivot` |
| `note` | tinyint (nullable) | Note de 1 à 10 |
| `commentaire` | text | |

> La clé primaire de `feuille_match` est la paire `(id_match, num_licence)` — un joueur ne peut figurer qu'une fois par match.  
> Les suppressions en cascade sont actives : supprimer un match supprime sa feuille ; supprimer un joueur le retire de toutes les feuilles.

### `utilisateur`
| Colonne | Type | Description |
|---|---|---|
| `login_utilisateur` | varchar(50) PK | |
| `mdp_hash` | char(60) | Hash bcrypt (`password_hash`) |

---

## Installation locale

**Prérequis :** PHP 8.x, MySQL / MariaDB, un serveur web (XAMPP, Laragon…)

```bash
# 1. Cloner le dépôt dans le dossier web du serveur
git clone <url-du-repo> hooptrack

# 2. Créer la base de données
# Dans phpMyAdmin ou MySQL CLI :
CREATE DATABASE basketball CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

# 3. Importer le schéma et les données de démo
mysql -u root basketball < data/basketball.sql

# 4. Configurer la connexion
# Éditer includes/_linkpdo.php et ajuster host, dbname, user, password
```

```php
// includes/_linkpdo.php
$linkpdo = new PDO("mysql:host=localhost;dbname=basketball;charset=utf8", 'root', '');
```

```
# 5. Ouvrir dans le navigateur
http://localhost/hooptrack/
```

---

## Sécurité

- Toutes les pages sont protégées par `includes/_session.php` : un utilisateur non connecté est redirigé vers la page de connexion.
- Les mots de passe sont hachés avec `password_hash` (bcrypt) et vérifiés avec `password_verify`.
- Toutes les requêtes SQL utilisent des **requêtes préparées PDO** avec paramètres liés — pas de concaténation directe.
- Les valeurs affichées en HTML passent par `htmlspecialchars` pour prévenir les injections XSS.
- Les données POST sont validées avant insertion (champs obligatoires, valeurs d'enum, types numériques).

---

## Technologies

- **PHP 8.x** — logique serveur, sessions, PDO
- **MySQL / MariaDB** — base de données relationnelle
- **HTML / CSS** — interface sans framework JS
- **PDO** — accès base de données avec requêtes préparées

---

## Notes techniques

| Notion | Explication |
|---|---|
| `===` | Comparaison stricte : vérifie à la fois la valeur **et** le type (ex : `0 === false` est faux) |
| `fetchColumn()` | Alternative à `fetch()` qui retourne directement la valeur d'une seule colonne (utilisé pour récupérer un hash ou un compteur) |
| `htmlspecialchars()` | Convertit les caractères spéciaux HTML (`<`, `>`, `"`) en entités pour éviter les injections XSS |
| `urlencode()` | Encode une chaîne pour l'inclure dans une URL (espaces → `%20`, accents → encodage %) |
| `setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)` | Configure PDO pour lever une exception PHP à chaque erreur SQL plutôt que de silencieusement échouer |
| `step` (HTML) | Attribut d'un `<input type="number">` qui définit l'incrément autorisé (ex : `step="0.1"` interdit `0.55`) |
| Préfixe `_` dans `includes/` | Convention pour distinguer les fragments réutilisables des pages complètes |
| Suffixe `_disp.php` dans `pages/` | Convention pour indiquer qu'un fichier est une page d'affichage (display) |
