-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 déc. 2023 à 15:56
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
-- Base de données : `shopsymfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `contenu_panier`
--

DROP TABLE IF EXISTS `contenu_panier`;
CREATE TABLE IF NOT EXISTS `contenu_panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `panier_id` int NOT NULL,
  `quantite` int NOT NULL,
  `date_ajout` datetime NOT NULL,
  `produit_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_80507DC0F77D927C` (`panier_id`),
  KEY `IDX_80507DC0F347EFB` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contenu_panier`
--

INSERT INTO `contenu_panier` (`id`, `panier_id`, `quantite`, `date_ajout`, `produit_id`) VALUES
(1, 4, 1, '2023-12-08 14:56:17', 9),
(2, 4, 1, '2023-12-08 14:56:17', 11),
(3, 4, 1, '2023-12-08 15:26:27', 9),
(4, 4, 1, '2023-12-08 15:26:27', 11),
(5, 5, 1, '2023-12-08 15:32:40', 13),
(6, 6, 1, '2023-12-08 15:32:44', 13),
(7, 7, 1, '2023-12-08 15:32:49', 13),
(8, 8, 1, '2023-12-08 15:35:43', 16),
(9, 9, 1, '2023-12-08 15:37:38', 12);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231206143122', '2023-12-06 14:31:52', 328),
('DoctrineMigrations\\Version20231207135449', '2023-12-07 13:54:53', 96),
('DoctrineMigrations\\Version20231207135825', '2023-12-08 11:24:36', 49),
('DoctrineMigrations\\Version20231208112651', '2023-12-08 11:26:55', 200),
('DoctrineMigrations\\Version20231208113034', '2023-12-08 11:30:49', 207);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_achat` date NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_24CC0DF2A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `user_id`, `date_achat`, `etat`) VALUES
(4, 2, '2023-12-08', 1),
(5, 1, '2023-12-08', 1),
(6, 1, '2023-12-08', 1),
(7, 1, '2023-12-08', 1),
(8, 7, '2023-12-08', 1),
(9, 7, '2023-12-08', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `prix` double NOT NULL,
  `stock` int NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix`, `stock`, `photo`) VALUES
(9, 'Echarpe super soft', 'Echarpe confectionnée à partir d’un fil en mélange de viscose.', 22.95, 2, '6570b73da03a7.jpg'),
(11, 'T-shirt blanc', 'Col rond, longueur classique en coton.', 17.95, 10, '6570b837604df.jpg'),
(12, 'T-shirt noir', 'Col rond, longueur classique en coton.', 17.95, 14, '6570b856b9cb7.jpg'),
(13, 'Baskets jaunes', 'Détail en contraste à l\'arrière. Fermeture à lacets.', 37.95, 4, '6570b8a602215.jpg'),
(16, 'Echarpe rouge', 'Echarpe confectionnée à partir d’un fil en mélange de viscose.', 25.95, 6, '657183b6df6ec.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'julien@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$NhU7i9ZQsbBOyABkLrNw8.R3.5FbLd47Dpbe7mTVqLwksNNF1zidC', 'Lefebvre', 'Julien'),
(2, 'emma@gmail.com', '[]', '$2y$13$Gdx8cKW56Ow3q35.OBja..XXZ7C3lmOFCwMpOTQ8cR2klCo1ck6Wm', 'Martin', 'Emma'),
(4, 'coualan@gmail.com', '[]', '$2y$13$t.TjxNAtlQtLapRpT.ermupMCAIDVWrwE488dDH98CsiNw95xRh5S', 'Coualan', 'Yoann'),
(5, 'cyril@gmail.com', '[]', '$2y$13$8y6H/LivZSPkmLQYU/nfuuDkRxp2hLmSsPDmnPzDPvtcxD.Y.xzVy', 'Lopez', 'Cyril'),
(7, 'jean@gmail.com', '[]', '$2y$13$TakcNW9lbTlYL3dBwqTnUuD4eQHZUDseGRDMJ.NxELQ20U9B6l04K', 'Dujardin', 'Jean');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenu_panier`
--
ALTER TABLE `contenu_panier`
  ADD CONSTRAINT `FK_80507DC0F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `FK_80507DC0F77D927C` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
