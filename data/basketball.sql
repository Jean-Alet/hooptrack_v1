-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 18 jan. 2026 à 15:20
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `basketball`
--

-- --------------------------------------------------------

--
-- Structure de la table `feuille_match`
--

CREATE TABLE `feuille_match` (
  `id_match` int(11) NOT NULL,
  `num_licence` char(8) NOT NULL,
  `role` enum('Titulaire','Remplaçant') NOT NULL,
  `poste` enum('Meneur','Arrière','Ailier','Ailier fort','Pivot') NOT NULL,
  `note` tinyint(4) DEFAULT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `feuille_match`
--

INSERT INTO `feuille_match` (`id_match`, `num_licence`, `role`, `poste`, `note`, `commentaire`) VALUES
(124, 'LIC00001', 'Titulaire', 'Ailier fort', NULL, ''),
(124, 'LIC00004', 'Titulaire', 'Arrière', NULL, ''),
(124, 'LIC00007', 'Titulaire', 'Ailier', NULL, ''),
(124, 'LIC00008', 'Titulaire', 'Meneur', NULL, ''),
(124, 'LIC00011', 'Titulaire', 'Pivot', 8, 'sympa'),
(125, 'LIC00001', 'Titulaire', 'Arrière', NULL, ''),
(125, 'LIC00004', 'Titulaire', 'Ailier fort', NULL, ''),
(125, 'LIC00007', 'Titulaire', 'Ailier', NULL, ''),
(125, 'LIC00008', 'Titulaire', 'Pivot', NULL, ''),
(125, 'LIC00011', 'Titulaire', 'Meneur', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `num_licence` char(8) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `taille` decimal(4,1) NOT NULL,
  `poids` decimal(5,2) NOT NULL,
  `nationalite` varchar(50) NOT NULL,
  `statut` enum('Actif','Blessé','Suspendu','Absent') NOT NULL DEFAULT 'Actif',
  `commentaires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`num_licence`, `nom`, `prenom`, `date_naissance`, `taille`, `poids`, `nationalite`, `statut`, `commentaires`) VALUES
('LIC00001', 'Dupont', 'Jean', '1990-05-12', 185.0, 82.50, '', 'Actif', 'Ailier droit'),
('LIC00004', 'Moreau', 'Alice', '2000-07-15', 168.0, 60.00, '', 'Actif', 'Jeune poussin'),
('LIC00005', 'Leroy', 'Marc', '1985-09-30', 198.0, 102.30, '', 'Suspendu', 'Ancien pivot'),
('LIC00007', 'Fabre', 'Nicolas', '1997-06-27', 190.0, 85.00, '', 'Actif', 'Remplaçant'),
('LIC00008', 'Garcia', 'Ana', '2002-12-05', 165.0, 58.20, '', 'Actif', 'Jeune espoir'),
('LIC00011', 'Declerck', 'Jack', '2000-06-08', 209.0, 105.00, 'France', 'Actif', 'MVP 2024, Superstar');

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id_match` int(11) NOT NULL,
  `date_match` datetime NOT NULL,
  `equipe_adverse` varchar(50) NOT NULL,
  `lieu` enum('Domicile','Extérieur') NOT NULL,
  `resultat` enum('Victoire','Défaite') DEFAULT NULL,
  `score_equipe` int(11) DEFAULT NULL,
  `score_adverse` int(11) DEFAULT NULL,
  `overtime` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `match`
--

INSERT INTO `match` (`id_match`, `date_match`, `equipe_adverse`, `lieu`, `resultat`, `score_equipe`, `score_adverse`, `overtime`) VALUES
(1, '2025-11-01 20:00:00', 'Tigers', 'Domicile', NULL, NULL, NULL, 0),
(2, '2025-11-08 18:30:00', 'Eagles', 'Extérieur', NULL, NULL, NULL, 0),
(3, '2025-11-15 19:00:00', 'Sharks', 'Domicile', 'Défaite', 90, 92, 0),
(4, '2025-11-21 16:00:00', 'Gorillas', 'Extérieur', 'Victoire', 100, 90, 0),
(5, '2025-11-25 10:30:00', 'Lions', 'Domicile', 'Victoire', 100, 90, 1),
(124, '2026-01-13 13:30:00', 'Hawks', 'Domicile', 'Victoire', 2, 1, 0),
(125, '2026-02-06 14:00:00', 'Jaguars', 'Domicile', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login_utilisateur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mdp_hash` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login_utilisateur`, `mdp_hash`) VALUES
('jean', '$2y$10$gwF2JMLnl2.WOk5Qus/TwO00vhDQ3jHX72J8x4UlSFbPLbrOyALZy'),
('ronan', '$2y$10$sJIt.dhAoAC7IZY1bV75XOyMnSQX9Kq.2YMIDmhdVd6SdSBY1c6Ka');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `feuille_match`
--
ALTER TABLE `feuille_match`
  ADD PRIMARY KEY (`id_match`,`num_licence`),
  ADD KEY `id_match` (`id_match`),
  ADD KEY `num_licence` (`num_licence`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`num_licence`);

--
-- Index pour la table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`id_match`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
  MODIFY `id_match` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `feuille_match`
--
ALTER TABLE `feuille_match`
  ADD CONSTRAINT `FK_idMatch` FOREIGN KEY (`id_match`) REFERENCES `match` (`id_match`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_numLicence` FOREIGN KEY (`num_licence`) REFERENCES `joueur` (`num_licence`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;