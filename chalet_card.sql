-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 30 mai 2023 à 13:06
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chalet_card`
--

-- --------------------------------------------------------

--
-- Structure de la table `chalets`
--

DROP TABLE IF EXISTS `chalets`;
CREATE TABLE IF NOT EXISTS `chalets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `chalets`
--

INSERT INTO `chalets` (`id`, `nom`, `adresse`, `description`, `image`) VALUES
(1, 'Chalet 1', 'Adresse 1', 'Description 1', 'image1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chalet_id` int DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `nombre_personnes` int DEFAULT NULL,
  `petit_dejeuner` tinyint(1) DEFAULT NULL,
  `repas` tinyint(1) DEFAULT NULL,
  `spa` tinyint(1) DEFAULT NULL,
  `all_in` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chalet_id` (`chalet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `chalet_id`, `date_reservation`, `nom`, `prenom`, `email`, `telephone`, `nombre_personnes`, `petit_dejeuner`, `repas`, `spa`, `all_in`) VALUES
(1, 1, '2023-05-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
