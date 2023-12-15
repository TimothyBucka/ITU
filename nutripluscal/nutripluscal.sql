-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 09:44 PM
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
  `bmi` double NOT NULL,
  `daily_intake` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `body_data`
--

INSERT INTO `body_data` (`id`, `height`, `weight`, `age`, `goal_target`, `bmi`, `daily_intake`) VALUES
(1, 177, 75, 21, 75, 23.9, 2553);

-- --------------------------------------------------------

--
-- Table structure for table `eaten`
--

CREATE TABLE `eaten` (
  `id` int(11) NOT NULL,
  `portion_size` float DEFAULT NULL,
  `date_of_eat` date DEFAULT NULL,
  `meal_id` int(11) DEFAULT NULL,
  `meal_time` enum('Breakfast','Lunch','Dinner','Snacks') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eaten`
--

INSERT INTO `eaten` (`id`, `portion_size`, `date_of_eat`, `meal_id`, `meal_time`) VALUES
(2, 200.1, '2023-12-05', 2, NULL),
(3, 201.5, '2023-12-05', 3, NULL),
(89, 50, '2023-12-03', 1, NULL),
(90, 50, '2023-12-03', 2, NULL),
(91, 50, NULL, 1, NULL),
(92, 50, NULL, 2, NULL),
(93, 50, NULL, 2, NULL),
(94, 50, NULL, 3, NULL),
(96, 50, '2023-12-04', 2, NULL),
(97, 50, NULL, 3, NULL),
(98, 50, NULL, 2, NULL),
(99, 50, NULL, 1, NULL),
(100, 50, NULL, 1, NULL),
(101, 50, NULL, 2, NULL),
(102, 50, '2023-12-04', 3, NULL),
(104, 50, '2023-12-06', 1, NULL),
(107, 50, '2023-12-08', 1, NULL),
(108, 50, '2023-12-08', 2, NULL),
(109, 50, '2023-12-14', 1, NULL),
(110, 50, '2023-12-09', 3, NULL),
(111, 50, '2023-12-09', 2, NULL),
(112, 50, '2023-12-07', 1, NULL),
(113, 50, '2023-12-12', 2, NULL),
(114, 50, '2023-12-12', 3, NULL),
(115, 50, NULL, 4, NULL),
(116, 50, NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `photo_path` varchar(128) DEFAULT NULL,
  `calories` float DEFAULT NULL,
  `proteins` float DEFAULT NULL,
  `carbs` float DEFAULT NULL,
  `fats` float DEFAULT NULL,
  `fibers` float DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `photo_path`, `calories`, `proteins`, `carbs`, `fats`, `fibers`, `restaurant_id`) VALUES
(1, 'Meal 1', 'path1', 100, 10, 20, 30.1, 40, 1),
(2, 'Meal 2', 'path2', 105, 15, 24, 31.5, 40, 1),
(3, 'Meal 3', 'path3', 110, 10, 20, 30.8, 40, 1),
(4, 'Weed', NULL, 0, 10, 0, 0, 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `photo_url` varchar(1000) DEFAULT NULL,
  `visited` int(11) DEFAULT NULL,
  `last_visited` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `type`, `phone`, `photo_url`, `visited`, `last_visited`) VALUES
(1, 'Menza Starý pivovar', 'Božetěchova 1, 612 00 Brno-Královo Pole', 'Restaurant', '541 141 010', 'stary_pivovar.jpg', 0, NULL),
(2, 'University Canteen Palacký', 'Kolejní 2905, 612 00 Brno-Královo Pole', 'Cafeteria', '541 142 900', 'palacky.jpg', 0, NULL),
(3, 'Pho Viet', 'Palackého tř. 464, 612 00 Brno-Královo Pole', 'Vietnamese restaurant', '533 534 535', 'pho_viet.jpg', 0, NULL),
(4, 'Gỗ Brno', 'Běhounská 4, 602 00 Brno-střed', 'Vietnamese restaurant', '720 021 575', 'go.jpg', 0, NULL),
(5, 'Pizzéria PAMP', 'Závodná 287, 027 43 Nižná, Slovakia', 'Pizza restaurant', '+421 43/538 12 84', 'pamp.jpg', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body_data`
--
ALTER TABLE `body_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eaten`
--
ALTER TABLE `eaten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_meal_eaten_meal` (`meal_id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_meal_restaurant` (`restaurant_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `body_data`
--
ALTER TABLE `body_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `eaten`
--
ALTER TABLE `eaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eaten`
--
ALTER TABLE `eaten`
  ADD CONSTRAINT `FK_meal_eaten_meal` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`);

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `FK_meal_restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
