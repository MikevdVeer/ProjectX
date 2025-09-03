-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 05:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcsa`
--
CREATE DATABASE IF NOT EXISTS `mcsa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mcsa`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Layout'),
(2, 'Shop'),
(3, 'Cards'),
(4, 'Data'),
(5, 'Navigation'),
(6, 'Animation'),
(7, 'Dashboard'),
(8, 'Premium Templates');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250602074221', '2025-06-18 16:06:38', 541),
('DoctrineMigrations\\Version20250613125241', '2025-06-18 16:06:39', 6),
('DoctrineMigrations\\Version20250618140625', NULL, NULL),
('DoctrineMigrations\\Version20250618140951', '2025-06-18 16:09:56', 9);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `template_id`, `user_id`, `title`, `description`, `date`) VALUES
(1, 1, 1, 'Amazing Gaming Template!', 'This template is perfect for gaming websites. The design is modern and the performance is excellent.', '2025-06-09 20:16:06'),
(2, 2, 1, 'Great for Real Estate', 'The Villa Agency template is well-structured and easy to customize. Perfect for real estate businesses.', '2025-06-09 20:16:06'),
(3, 4, 1, 'Professional Dashboard', 'Clean and professional admin dashboard. The UI is intuitive and the code is well-organized.', '2025-06-09 20:16:06'),
(4, 5, 1, 'Creative Card Design', 'Love the card designs in this template. Very modern and eye-catching.', '2025-06-09 20:16:06'),
(5, 6, 1, 'Amazing Template!', 'This template is perfect for gaming websites. The design is modern and the performance is excellent.', '2025-06-09 20:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `preview_img` varchar(255) NOT NULL,
  `preview_asset` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `name`, `price`, `preview_img`, `preview_asset`) VALUES
(1, 'Lugx Gaming Template', 1.00, 'lugx.png', 'templatemo_589_lugx_gaming'),
(2, 'Villa Agency Template', NULL, 'villa.png', 'templatemo_591_villa_agency\r\n'),
(3, 'Topic Listing Template', NULL, 'topic.png', 'templatemo_590_topic_listing'),
(4, 'Admin Dashboard', NULL, 'admin dashboard.png', '2108_dashboard'),
(5, 'Cyborg cards', 15.00, 'cyborg cards.png', 'templatemo_579_cyborg_gaming'),
(6, 'Liberty Market', 50.00, 'liberty.png', 'templatemo_577_liberty_market'),
(7, 'Barbershop', 110.00, 'barbershop.png', 'templatemo_585_barber_shop'),
(8, 'WoOx Travel', 25.29, 'woox.png', 'templatemo_580_woox_travel'),
(9, 'Time To Talk', 9.99, 'timetotalk.png', 'templatemo_584_pod_talk');

-- --------------------------------------------------------

--
-- Table structure for table `template_category`
--

CREATE TABLE `template_category` (
  `template_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template_category`
--

INSERT INTO `template_category` (`template_id`, `category_id`) VALUES
(1, 8),
(2, 1),
(3, 1),
(4, 7),
(5, 3),
(6, 2),
(7, 8),
(8, 2),
(9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `template_order`
--

CREATE TABLE `template_order` (
  `template_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `profile_picture`, `username`) VALUES
(1, '302815715@admin.com', '[\"ROLE_ADMIN\"]', '$2y$13$W52IHJcyn894nRkbwoCzyuub2Wh0X.MTCdBWoxQhneHIEj6VIoplO', 'Meliodas-catboy-6852caad4af29.jpg', 'CFU');

-- --------------------------------------------------------

--
-- Table structure for table `user_template`
--

CREATE TABLE `user_template` (
  `user_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_794381C65DA0FB8` (`template_id`),
  ADD KEY `IDX_794381C6A76ED395` (`user_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_category`
--
ALTER TABLE `template_category`
  ADD PRIMARY KEY (`template_id`,`category_id`),
  ADD KEY `IDX_591A29B25DA0FB8` (`template_id`),
  ADD KEY `IDX_591A29B212469DE2` (`category_id`);

--
-- Indexes for table `template_order`
--
ALTER TABLE `template_order`
  ADD PRIMARY KEY (`template_id`,`order_id`),
  ADD KEY `IDX_C6FF40575DA0FB8` (`template_id`),
  ADD KEY `IDX_C6FF40578D9F6D38` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indexes for table `user_template`
--
ALTER TABLE `user_template`
  ADD PRIMARY KEY (`user_id`,`template_id`),
  ADD KEY `IDX_77EDFB83A76ED395` (`user_id`),
  ADD KEY `IDX_77EDFB835DA0FB8` (`template_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `template_category`
--
ALTER TABLE `template_category`
  ADD CONSTRAINT `FK_591A29B212469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_591A29B25DA0FB8` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_order`
--
ALTER TABLE `template_order`
  ADD CONSTRAINT `FK_C6FF40575DA0FB8` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C6FF40578D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_template`
--
ALTER TABLE `user_template`
  ADD CONSTRAINT `FK_77EDFB835DA0FB8` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_77EDFB83A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
