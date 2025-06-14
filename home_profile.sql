-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 09:07 AM
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
-- Database: `lms_e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `home_profile`
--

CREATE TABLE `home_profile` (
  `id` int(11) NOT NULL,
  `slide01` varchar(255) NOT NULL,
  `slide02` varchar(255) NOT NULL,
  `slide03` varchar(255) NOT NULL,
  `icon01` varchar(255) NOT NULL,
  `icon02` varchar(255) NOT NULL,
  `icon03` varchar(255) NOT NULL,
  `icon04` varchar(255) NOT NULL,
  `icon05` varchar(255) NOT NULL,
  `icon06` varchar(255) NOT NULL,
  `icon07` varchar(255) NOT NULL,
  `icon08` varchar(255) NOT NULL,
  `icon09` varchar(255) NOT NULL,
  `youtube_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_profile`
--

INSERT INTO `home_profile` (`id`, `slide01`, `slide02`, `slide03`, `icon01`, `icon02`, `icon03`, `icon04`, `icon05`, `icon06`, `icon07`, `icon08`, `icon09`, `youtube_id`) VALUES
(1, 'slide01.png', 'slide02.png', 'slide03.png', 'icon01.png', 'icon02.png', 'icon03.png', 'icon04.png', 'icon05.png', 'icon06.png', 'icon07.png', 'icon08.png', 'icon09.png', 'LTp7DxJpcUY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `home_profile`
--
ALTER TABLE `home_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `home_profile`
--
ALTER TABLE `home_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
