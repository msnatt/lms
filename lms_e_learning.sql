-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 08:21 AM
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
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `unit_id`, `type_id`, `content`, `create_date`, `update_date`, `is_deleted`) VALUES
(1, 1, 1, 'Geo Unit 1 \r\nContent of Geo Unit 1 with Text', '2025-03-06', '2025-03-06', 0),
(2, 2, 1, 'Geo Unit 2 \r\nContent of Geo Unit 2 with Text', '2025-03-06', '2025-03-06', 0),
(3, 3, 1, 'Content of facebook Unit 1 with Text', '2025-03-06', '2025-03-06', 0),
(4, 4, 2, '../uploads/admin/mushroom_forest.png', '2025-03-06', '2025-03-06', 0),
(5, 4, 3, 'https://www.youtube.com/embed/EFmxPMdBqmU', '2025-03-06', '2025-03-06', 0),
(6, 3, 4, '../uploads/admin/Elearning_TOR.pdf', '2025-03-06', '2025-03-06', 0),
(9, 7, 1, 'content Text of Course Test', '2025-03-19', '2025-03-19', 0),
(10, 7, 2, '../uploads/admin/H2522efcc054a4c71ae0e0617e01411c.jpg', '2025-03-19', '2025-03-19', 0),
(11, 7, 1, 'mushroom glowing', '2025-03-19', '2025-03-19', 0),
(12, 7, 2, '../uploads/admin/mushroom_forest.png', '2025-03-19', '2025-03-19', 0),
(13, 8, 1, '<h2>Text ไงงง</h2>', '2025-03-19', '2025-03-19', 0),
(14, 8, 2, '../uploads/admin2/mushroom_forest.png', '2025-03-19', '2025-03-19', 0),
(15, 9, 1, 'Photo environment', '2025-03-19', '2025-03-19', 0),
(16, 9, 1, '<h3>Room</h3>', '2025-03-19', '2025-03-19', 0),
(17, 9, 2, '../uploads/admin/3_รักตัวเอง-01.jpg', '2025-03-19', '2025-03-19', 0),
(18, 9, 1, '<h3>Employee</h3>', '2025-03-19', '2025-03-19', 0),
(19, 9, 2, '../uploads/admin/GhzRRSsbQAEThSp.jfif', '2025-03-19', '2025-03-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `image_code` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `objective` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `create_by` int(11) NOT NULL DEFAULT 0 COMMENT 'create by user_id',
  `update_by` int(11) NOT NULL DEFAULT 0 COMMENT 'update by user_id',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `code`, `image_code`, `name`, `description`, `objective`, `create_date`, `update_date`, `create_by`, `update_by`, `is_deleted`) VALUES
(1, '110210', 2, 'Geolocator', 'This is Description of Geolocator Course', '', '2025-03-03', '2025-03-03', 1, 0, 0),
(2, '110222', 3, 'Facebook Course', 'This is Description of Facebook Course\r\n', '', '2025-03-03', '2025-03-03', 3, 0, 0),
(7, '12345123', 4, 'Course Test', 'Description  Course Test', 'Objective Course Test', '2025-03-19', '2025-03-19', 3, 0, 0),
(8, '0101110', 1, 'Course programing', 'Course programing Description', 'Course programing Objective', '2025-03-19', '2025-03-19', 5, 0, 0),
(9, '101010', 6, 'Thai massage', 'Thai masssage in your heart', '- relax\r\n- comfortable', '2025-03-19', '2025-03-19', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `point` float NOT NULL DEFAULT 0,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_student`
--

INSERT INTO `course_student` (`id`, `course_id`, `unit_id`, `content_id`, `owner_id`, `point`, `create_date`, `update_date`, `is_active`, `is_deleted`) VALUES
(1, 9, 9, 15, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(2, 9, 9, 16, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(3, 9, 9, 17, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(4, 9, 9, 18, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(5, 9, 9, 19, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(6, 8, 8, 13, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(7, 8, 8, 14, 2, 0, '2025-03-20', '2025-03-20', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `filepath` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typefile`
--

CREATE TABLE `typefile` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typefile`
--

INSERT INTO `typefile` (`id`, `name`, `create_date`, `update_date`, `is_deleted`) VALUES
(1, 'Text Box', '2025-03-06', '2025-03-06', 0),
(2, 'Image', '2025-03-06', '2025-03-06', 0),
(3, 'Video', '2025-03-06', '2025-03-06', 0),
(4, 'PDF', '2025-03-06', '2025-03-06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `course_id`, `name`, `create_date`, `update_date`, `is_deleted`) VALUES
(1, 1, 'Geolocator Unit 1', '2025-03-06', '2025-03-06', 0),
(2, 1, 'Geolocator Unit 2', '2025-03-06', '2025-03-06', 0),
(3, 2, 'Facebook Course Unit 1', '2025-03-06', '2025-03-06', 0),
(4, 2, 'Facebook Course Unit 2', '2025-03-06', '2025-03-06', 0),
(7, 7, 'Header 01 of Course Test', '2025-03-19', '2025-03-19', 0),
(8, 8, 'preview', '2025-03-19', '2025-03-19', 0),
(9, 9, 'massage shop', '2025-03-19', '2025-03-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_pushhandup` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`, `rank`, `telephone`, `create_date`, `update_date`, `is_pushhandup`, `is_admin`, `is_deleted`) VALUES
(1, 'Adminitrator', 'admin@gmail.com', 'admin', 'admin', 0, '0987654321', '2025-03-03', '2025-03-03', 0, 1, 0),
(2, 'user', 'user@gmail.com', 'user', 'user', 1, '1234567890', '2025-03-03', '2025-03-03', 0, 0, 0),
(3, 'Adminitrator2', 'admin2@gmail.com', 'admin2', 'admin', 0, '0123456789', '2025-03-03', '2025-03-03', 0, 1, 0),
(5, 'Adminitrator2', 'admin2@gmail.com', 'admin3', 'admin', 0, '0123456789', '2025-03-03', '2025-03-03', 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id_content__id_type` (`type_id`),
  ADD KEY `unit_id_content__id_unit` (`unit_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_course_student__id_course` (`course_id`),
  ADD KEY `unit_id_course_student__id_unit` (`unit_id`),
  ADD KEY `owner_id_course_student__id_user` (`owner_id`),
  ADD KEY `content_id_course_student__id_content` (`content_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id_file__id_content` (`content_id`);

--
-- Indexes for table `typefile`
--
ALTER TABLE `typefile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_unit__id_course` (`course_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typefile`
--
ALTER TABLE `typefile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `type_id_content__id_type` FOREIGN KEY (`type_id`) REFERENCES `typefile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_id_content__id_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `content_id_course_student__id_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`),
  ADD CONSTRAINT `course_id_course_student__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `owner_id_course_student__id_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `unit_id_course_student__id_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `content_id_file__id_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `course_id_unit__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
