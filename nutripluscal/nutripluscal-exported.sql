-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 12:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutripluscal`
--

-- --------------------------------------------------------

--
-- Table structure for table `body_data`
--

CREATE TABLE `body_data` (
  `id` int(11) NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `age` int(10) NOT NULL,
  `goal_target` double NOT NULL,
  `bmi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `body_data`
--

INSERT INTO `body_data` (`id`, `height`, `weight`, `age`, `goal_target`, `bmi`) VALUES
(1, 195, 150, 23, 75, 39.4),
(2, 181, 61, 21, 65, 20),
(3, 182, 62, 22, 65, 20),
(4, 179, 63, 23, 66, 21),
(5, 178, 64, 24, 65, 18),
(6, 177, 65, 25, 64, 19),
(7, 176, 66, 26, 62, 20),
(8, 175, 67, 27, 65, 20),
(9, 174, 68, 28, 65, 21),
(10, 173, 59, 18, 64, 22),
(11, 172, 60, 19, 62, 20);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `calories` int(10) UNSIGNED NOT NULL,
  `proteins` int(10) UNSIGNED NOT NULL,
  `carbs` int(10) UNSIGNED NOT NULL,
  `fats` int(10) UNSIGNED NOT NULL,
  `fiber` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body_data`
--
ALTER TABLE `body_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `body_data`
--
ALTER TABLE `body_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
