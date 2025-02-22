-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 17 fév. 2025 à 19:53
-- Version du serveur : 11.6.2-MariaDB
-- Version de PHP : 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_ventes`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `nom`, `email`, `mot_de_passe`) VALUES
(1, 'admin', 'admin@foodmart.ma', '123');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `client_id`, `produit_id`, `quantite`, `date_ajout`) VALUES
(17, 1, 6, 5, '2025-02-14 21:02:19'),
(18, 1, 7, 5, '2025-02-14 21:03:30');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `email`, `mot_de_passe`, `telephone`, `adresse`, `points`) VALUES
(1, 'Ahmed Khairi', 'ahmed.khair@example.com', 'hashed_password', '0654321987', 'Fès', 30),
(2, 'Saida Maarouf', 'saida.maarouf@example.com', 'hashed_password', '0677214356', 'Marrakech', 50),
(3, 'Youssef Idrissi', 'youssef.idrissi@example.com', 'hashed_password', '0634567890', 'Casablanca', 20),
(4, 'Zineb Laarabi', 'zineb.laarabi@example.com', 'hashed_password', '0667788990', 'Rabat', 40),
(5, 'Karim Toumi', 'karim.toumi@example.com', 'hashed_password', '0612345567', 'Tanger', 25),
(6, 'Imane Elouahabi', 'imane.elouahabi@example.com', 'hashed_password', '0623458769', 'Agadir', 15),
(7, 'Rania Mansouri', 'rania.mansouri@example.com', 'hashed_password', '0698764321', 'Meknès', 35),
(8, 'Hassan Bouzid', 'hassan.bouzid@example.com', 'hashed_password', '0643219876', 'Oujda', 50),
(9, 'Noura Belkhir', 'noura.belkhir@example.com', 'hashed_password', '0678123456', 'Laâyoune', 45),
(10, 'Ibrahim Chahine', 'ibrahim.chahine@example.com', 'hashed_password', '0619876543', 'Tétouan', 30);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `statut` enum('en attente','expédiée','livrée') DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `type_livraison` enum('express','standard') DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `product_ids` varchar(255) DEFAULT NULL,
  `quantities` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `date_commande`, `statut`, `total`, `type_livraison`, `date_livraison`, `product_ids`, `quantities`) VALUES
(15, 1, '2025-02-14 00:00:00', 'en attente', '40.00', 'express', '2025-02-14', '4', '4'),
(16, 1, '2025-02-14 00:00:00', 'en attente', '240.00', 'standard', '2025-02-21', '4', '4'),
(17, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(18, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(19, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(20, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(21, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(22, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(23, 1, '2025-02-14 00:00:00', 'en attente', '260.00', 'standard', '2025-02-14', '4', '4'),
(24, 1, '2025-02-14 00:00:00', 'en attente', '30.00', 'standard', '2025-02-14', '9', '2'),
(25, 1, '2025-02-14 00:00:00', 'en attente', '440.00', 'standard', '2025-02-15', '6', '2');

-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `points_gagnes` int(11) DEFAULT NULL,
  `points_utilises` int(11) DEFAULT NULL,
  `date_expiration` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `coupons`
--

INSERT INTO `coupons` (`id`, `client_id`, `points_gagnes`, `points_utilises`, `date_expiration`) VALUES
(1, 1, 50, 10, '2025-03-01'),
(2, 2, 30, 20, '2025-02-15'),
(3, 3, 40, 15, '2025-04-01');

-- --------------------------------------------------------

--
-- Structure de la table `details_commandes`
--

CREATE TABLE `details_commandes` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `quantite_stock` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `promotion` decimal(5,2) DEFAULT 0.00,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `reference`, `designation`, `prix`, `quantite_stock`, `categorie`, `date_peremption`, `promotion`, `image_path`) VALUES
(3, 'PROD003', 'Couscous', '20.00', 200, 'produits secs', '2026-01-01', '5.00', '../../uploads/67af9221ddd3e_download.jpeg'),
(4, 'PROD004', 'Eau minérale', '5.00', 500, 'boissons', '2025-08-01', '0.00', '../../uploads/67af927362a98_download (1).jpeg'),
(5, 'PROD005', 'Miel de fleurs', '100.00', 80, 'produits frais', '2025-11-15', '15.00', '../../uploads/67af92cab5172_download (2).jpeg'),
(6, 'PROD006', 'Dattes Majhoul', '120.00', 150, 'produits frais', '2025-12-01', '20.00', '../../uploads/67af930cd23e0_Datte-medjool-3.jpg'),
(7, 'PROD007', 'Harissa', '10.00', 300, 'produits secs', '2026-02-15', '0.00', '../../uploads/67af93364f0c9_images.jpeg'),
(8, 'PROD008', 'Farine', '12.00', 400, 'produits secs', '2025-10-01', '15.00', '../../uploads/67af9352eb9ae_download (3).jpeg'),
(9, 'PROD009', 'Jus d\'Orange', '15.00', 250, 'boissons', '2025-07-01', '5.00', '../../uploads/67af93e79ffbc_download (4).jpeg'),
(10, 'PROD010', 'Chocolat Noir', '50.00', 120, 'produits secs', '2026-03-01', '10.00', '../../uploads/67af9418bce39_download (5).jpeg'),
(11, 'PROD011', 'Huile d\'Argan', '300.00', 150, 'Bio', '2025-01-17', '0.00', '../../uploads/67af9452d8ffe_download (6).jpeg'),
(12, 'PROD012', 'Pomme de terre', '8.00', 30, 'Bio', '2025-01-31', '0.00', '../../uploads/67af9487a2078_download (7).jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `reduction` decimal(5,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`id`, `produit_id`, `reduction`, `date_debut`, `date_fin`) VALUES
(2, 5, '15.00', '2025-01-15', '2025-02-15'),
(3, 10, '5.00', '2025-02-01', '2025-02-28'),
(6, 8, '15.00', '2025-02-14', '2025-02-15');

--
-- Déclencheurs `promotions`
--
DELIMITER $$
CREATE TRIGGER `update_produit_promotion` AFTER INSERT ON `promotions` FOR EACH ROW BEGIN
    UPDATE produits
    SET promotion = NEW.reduction
    WHERE id = NEW.produit_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `vendeurs`
--

CREATE TABLE `vendeurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `adresse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vendeurs`
--

INSERT INTO `vendeurs` (`id`, `nom`, `email`, `mot_de_passe`, `telephone`, `adresse`) VALUES
(1, 'Ali Benhadi', 'ali.benhadi@example.com', 'hashed_password', '0612345678', 'Casablanca'),
(2, 'Fatima Zahra', 'fatima.zahra@example.com', 'hashed_password', '0661123344', 'Rabat'),
(3, 'Hicham Ouali', 'hicham.ouali@example.com', 'hashed_password', '0623456789', 'Marrakech'),
(4, 'Saida Nouh', 'saida.nouh@example.com', 'hashed_password', '0678901234', 'Fès'),
(5, 'Rachid Ammar', 'rachid.ammar@example.com', 'hashed_password', '0643210987', 'Agadir'),
(6, 'Samira Karim', 'samira.karim@example.com', 'hashed_password', '0611223344', 'Tanger'),
(7, 'Yassine Mourad', 'yassine.mourad@example.com', 'hashed_password', '0677889900', 'Oujda'),
(8, 'Ahmed Khayri', 'ahmed.khayri@example.com', 'hashed_password', '0681234567', 'Laâyoune'),
(9, 'Sara Amrani', 'sara.amrani@example.com', 'hashed_password', '0698765432', 'Meknès'),
(10, 'Khalid Berrada', 'khalid.berrada@example.com', 'hashed_password', '0654321987', 'Casablanca');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `details_commandes`
--
ALTER TABLE `details_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `details_commandes`
--
ALTER TABLE `details_commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `details_commandes`
--
ALTER TABLE `details_commandes`
  ADD CONSTRAINT `details_commandes_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `details_commandes_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
