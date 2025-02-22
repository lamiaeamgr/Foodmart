-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 10:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `gestion_ventes`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `nom`, `email`, `mot_de_passe`) VALUES
(1, 'admin', 'admin@foodmart.ma', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `client_id`, `produit_id`, `quantite`, `date_ajout`) VALUES
(41, 1, 6, 1, '2025-02-22 21:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
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
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `email`, `mot_de_passe`, `telephone`, `adresse`, `points`) VALUES
(1, 'Ahmed Khairi', 'ahmed.khair@example.com', '123456', '0654321988', 'Fes', 19),
(2, 'Saida Maarouf', 'saida.maarouf@example.com', 'hashed_password', '0677214356', 'Marrakech', 50),
(3, 'Youssef Idrissi', 'youssef.idrissi@example.com', 'hashed_password', '0634567890', 'Casablanca', 20),
(4, 'Zineb Laarabi', 'zineb.laarabi@example.com', 'hashed_password', '0667788990', 'Rabat', 40),
(5, 'Karim Toumi', 'karim.toumi@example.com', 'hashed_password', '0612345567', 'Tanger', 25),
(6, 'Imane Elouahabi', 'imane.elouahabi@example.com', 'hashed_password', '0623458769', 'Agadir', 15),
(7, 'Rania Mansouri', 'rania.mansouri@example.com', 'hashed_password', '0698764321', 'Meknès', 35),
(8, 'Hassan Bouzid', 'hassan.bouzid@example.com', 'hashed_password', '0643219876', 'Oujda', 50),
(9, 'Noura Belkhir', 'noura.belkhir@example.com', 'hashed_password', '0678123456', 'Laâyoune', 45),
(10, 'Ibrahim Chahine', 'ibrahim.chahine@example.com', 'hashed_password', '0619876543', 'Tétouan', 30),
(11, 'ali alami', 'alami@gmail.com', '$2y$10$x7fopVQh3nbdMnsAQcMDTe8G.3fSUDPbtMRfE1pBh0JCBBfHI5R7m', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `statut` enum('en attente','expédiée','livrée') DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `type_livraison` enum('au magasin','a domicile') DEFAULT NULL,
  `date_livraison` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `date_commande`, `statut`, `total`, `type_livraison`, `date_livraison`) VALUES
(34, 1, '2025-02-22 00:00:00', 'en attente', 10.00, '', '2025-03-01'),
(35, 1, '2025-02-22 00:00:00', 'en attente', 250.00, '', '2025-02-21'),
(36, 1, '2025-02-22 00:00:00', 'en attente', 320.00, 'au magasin', '2025-02-22'),
(37, 1, '2025-02-22 00:00:00', 'en attente', 380.00, 'au magasin', '2025-02-23'),
(38, 1, '2025-02-22 00:00:00', 'en attente', 5.00, 'au magasin', '2025-02-28'),
(39, 1, '2025-02-22 00:00:00', 'expédiée', 490.00, 'au magasin', '2025-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `valeur` decimal(10,2) NOT NULL,
  `type` enum('montant','pourcentage') NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `points_utilises` int(11) DEFAULT NULL,
  `is_used` varchar(255) NOT NULL,
  `date_expiration` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `valeur`, `type`, `client_id`, `points_utilises`, `is_used`, `date_expiration`) VALUES
(9, '3A31A169', 20.00, 'montant', 1, 150, '1', '2025-03-24'),
(10, 'B31C1D8F', 20.00, 'montant', 1, 150, '1', '2025-03-24'),
(11, 'F9DDA222', 300.00, 'montant', 1, 1580, '0', '2025-03-24'),
(12, 'F9E19DBD', 20.00, 'montant', 1, 100, '', '2025-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `details_commandes`
--

CREATE TABLE `details_commandes` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `details_commandes`
--

INSERT INTO `details_commandes` (`id`, `commande_id`, `produit_id`, `quantite`, `prix_unitaire`) VALUES
(6, 34, 4, 2, 10.00),
(7, 35, 4, 2, 10.00),
(8, 35, 6, 2, 240.00),
(9, 36, 4, 4, 20.00),
(10, 36, 6, 1, 120.00),
(11, 36, 5, 2, 200.00),
(12, 37, 5, 4, 400.00),
(13, 38, 4, 1, 5.00),
(14, 39, 10, 3, 150.00),
(15, 39, 6, 3, 360.00);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
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
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `reference`, `designation`, `prix`, `quantite_stock`, `categorie`, `date_peremption`, `promotion`, `image_path`) VALUES
(4, 'PROD004', 'Eau minérale', 5.00, 500, 'boissons', '2025-08-01', 10.00, '../../uploads/67af927362a98_download (1).jpeg'),
(5, 'PROD005', 'Miel de fleurs', 100.00, 80, 'produits frais', '2025-11-15', 10.00, '../../uploads/67af92cab5172_download (2).jpeg'),
(6, 'PROD006', 'Dattes Majhoul', 120.00, 150, 'produits frais', '2025-12-01', 20.00, '../../uploads/67af930cd23e0_Datte-medjool-3.jpg'),
(7, 'PROD007', 'Harissa', 10.00, 300, 'produits secs', '2026-02-15', 0.00, '../../uploads/67af93364f0c9_images.jpeg'),
(8, 'PROD008', 'Farine', 12.00, 400, 'produits secs', '2025-10-01', 15.00, '../../uploads/67af9352eb9ae_download (3).jpeg'),
(9, 'PROD009', 'Jus d\'Orange', 15.00, 250, 'boissons', '2025-07-01', 5.00, '../../uploads/67af93e79ffbc_download (4).jpeg'),
(10, 'PROD010', 'Chocolat Noir', 50.00, 120, 'produits secs', '2026-03-01', 10.00, '../../uploads/67af9418bce39_download (5).jpeg'),
(11, 'PROD011', 'Huile d\'Argan', 300.00, 150, 'Bio', '2025-01-17', 0.00, '../../uploads/67af9452d8ffe_download (6).jpeg'),
(12, 'PROD012', 'Pomme de terre', 8.00, 35, 'Bio', '2025-01-31', 5.00, '../../uploads/67af9487a2078_download (7).jpeg'),
(16, 'PROD035', 'Oulmes', 12.00, 20, 'Boissons', '2025-02-23', 10.00, '../../uploads/67ba3b502d17c_download (5).jfif');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `reduction` decimal(5,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `produit_id`, `reduction`, `date_debut`, `date_fin`) VALUES
(2, 5, 15.00, '2025-01-15', '2025-02-15'),
(3, 10, 5.00, '2025-02-01', '2025-02-28'),
(7, 5, 10.00, '2025-02-21', '2025-02-23'),
(8, 4, 10.00, '2025-02-22', '2025-03-05');

--
-- Triggers `promotions`
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
-- Table structure for table `vendeurs`
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
-- Dumping data for table `vendeurs`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `details_commandes`
--
ALTER TABLE `details_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `vendeurs`
--
ALTER TABLE `vendeurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `details_commandes`
--
ALTER TABLE `details_commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vendeurs`
--
ALTER TABLE `vendeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `details_commandes`
--
ALTER TABLE `details_commandes`
  ADD CONSTRAINT `details_commandes_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `details_commandes_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;
