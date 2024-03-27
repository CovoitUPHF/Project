-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 mars 2024 à 12:32
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tpl3info`
--

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

DROP TABLE IF EXISTS `conducteur`;
CREATE TABLE IF NOT EXISTS `conducteur` (
  `ID` int NOT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `Note` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `Nom` varchar(100) DEFAULT NULL,
  `Coordonnées` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_trajet` int DEFAULT NULL,
  `id_passager` int DEFAULT NULL,
  `id_conducteur` int DEFAULT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `id_trajet` (`id_trajet`),
  KEY `id_passager` (`id_passager`),
  KEY `id_conducteur` (`id_conducteur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_trajet`, `id_passager`, `id_conducteur`) VALUES
(1, 9, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_conducteur` int NOT NULL,
  `point_depart` varchar(100) NOT NULL,
  `point_arrivee` varchar(100) NOT NULL,
  `NbPlace` int NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_conducteur` (`ID_conducteur`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`ID`, `ID_conducteur`, `point_depart`, `point_arrivee`, `NbPlace`, `date`, `heure`) VALUES
(6, 0, 'rouen', 'valenciennes', 3, '2024-03-15', '12:00:00'),
(7, 2, 'saint denis', 'valenciennes', 0, '2024-03-15', '12:00:00'),
(8, 2, 'saint denis', 'valenciennes', 0, '2024-03-16', '12:00:00'),
(9, 3, 'paris', 'lille', 0, '2024-03-16', '12:00:00'),
(10, 1, 'amiens', 'valenciennes', 2, '2024-03-16', '12:00:00'),
(11, 1, 'amiens', 'valenciennes', 2, '2024-04-22', '08:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  `Prenom` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `MotDePasse` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `Nom`, `Prenom`, `email`, `date_naissance`, `MotDePasse`) VALUES
(1, 'joannen', 'jeffrey', 'jeffrey.joannen@uphf.fr', NULL, '$2y$10$Mhj.mYfpYX1zbc6WOS9zhOehDxsMaHzFocXTkJrKzvTMHYTl7CBge'),
(2, 'macrez', 'alexandre', 'alexandre.macrez@uphf.fr', '2003-11-11', '$2y$10$nzF4rwrlK34SmX/KtgUgZu4Qf97D7ElC5NrJwpebqgMxhPSGNz8R2'),
(3, 'rabin', 'paul', 'paul.rabin@uphf.fr', '2003-12-12', '$2y$10$kIk9OQI2wSCIM11IfKjLzeeZe5KClFC4NNniPtvP9wAAydVEfExN2');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `insee_code` int DEFAULT NULL,
  `city_code` varchar(100) DEFAULT NULL,
  `zip_code` int DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `department_number` int DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `region_geojson_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
