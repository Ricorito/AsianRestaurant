-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 11:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webterv`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_images` varchar(255) NOT NULL,
  `product_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_price`, `product_images`, `product_description`) VALUES
(1, 'Szerencse sertéscsülök', 3200, '../img/kinai_etelek/szerencse%20sertéscsülök.jpeg', 'kívül ropogós, belül szaftos, ínycsiklandó ízekkel.'),
(2, 'Avokádos temaki', 4200, '../img/japan_etelek/avokádó%20temaki.jpeg', 'Friss avokádó és ízletes töltelék tökéletesen göngyölve.'),
(3, 'Csirkés Curry Rízzsel', 3600, '../img/japan_etelek/csirkés%20curyy%20rizzsel.jpeg', 'Fűszeres csirkemell és krémes curry mártás a könnyed rizs mellett.'),
(4, 'Garasu', 2990, '../img/japan_etelek/Garasu.jpeg', 'Ízletes és ropogós snack, mely a japán konyhából ismert.'),
(5, 'Ge-shan csirke combból', 5000, '../img/kinai_etelek/Ge-shan%20csirke%20combból.jpeg', 'Csirkecomb, melyet jellegzetes fűszerekkel és szósszal ízesítenek.'),
(6, 'Érlelt szójabab', 2500, '../img/japan_etelek/érlelt%20szójabab.png', 'Gazdag ízű és textúrájú'),
(7, 'Vaslapon sült marha', 4500, '../img/kinai_etelek/vaslapon%20sült%20marha.jpeg', 'Ropogósra sütött marhahús, melyet egy forró vaslapon készítűnk'),
(8, 'Miss Mocha', 1690, '../img/kinai_etelek/Miss%20mocha.jpeg', 'Csokoládés-kávés desszert.');

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

CREATE TABLE `stars` (
  `id` int(11) NOT NULL,
  `rateIndex` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stars`
--

INSERT INTO `stars` (`id`, `rateIndex`) VALUES
(4, 3),
(5, 4),
(6, 1),
(7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `surname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(5) DEFAULT NULL,
  `LOGGED_IN` varchar(10) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`surname`, `firstname`, `email`, `address`, `phone`, `password`, `role`, `LOGGED_IN`, `profile_picture`) VALUES
('Germán', 'Martin', 'martingerman@gmail.com', 'Kossuth utca 57', '+36704340342', '$2y$10$1Qu2nvDB8UzvrGQwRKnWV.8ILtSSJhs94hhTsMespLQ0H/uhgPS2G', 'user', NULL, NULL),
('Germán', 'Martin', 'martingerman991@gmail.com', '5726 Méhkerék, Kossuth utca 57.', '+36704340342', '$2y$10$IC.wbeNodfH67mipynjqhOQ35ho9VDf6sD6tEpPgqtLW7c3cLIDy6', 'user', '0', '../img/profilePictures/dbd8a47f5c6a39a60c3f5eb73833d5a8.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stars`
--
ALTER TABLE `stars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
