-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 03:48 AM
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
(3, 3, 1, 'adwasfasdawda', '2025-03-06', '2025-03-06', 0),
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
(19, 9, 2, '../uploads/admin/GhzRRSsbQAEThSp.jfif', '2025-03-19', '2025-03-19', 0),
(20, 10, 1, 'Text Box about New content in Unit 3', '2025-03-22', '2025-03-22', 0),
(23, 10, 2, '../uploads/admin2/IMG_5493.JPG', '2025-03-24', '2025-03-24', 0),
(24, 11, 2, '../uploads/admin2/Later_Media_-_Instagram_Bio_Nov.png', '2025-03-24', '2025-03-24', 0),
(25, 11, 2, '../uploads/admin2/images.png', '2025-03-24', '2025-03-24', 0),
(26, 12, 1, 'This Image', '2025-03-24', '2025-03-24', 0),
(27, 12, 2, '../uploads/admin2/instagram-pin-posts.png', '2025-03-24', '2025-03-24', 0),
(28, 12, 2, '../uploads/admin2/canva-black-and-beige-photo-new.png', '2025-03-24', '2025-03-24', 0);

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
  `faculty_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `create_by` int(11) NOT NULL DEFAULT 0 COMMENT 'create by user_id',
  `update_by` int(11) NOT NULL DEFAULT 0 COMMENT 'update by user_id',
  `is_publish` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `code`, `image_code`, `name`, `description`, `objective`, `faculty_id`, `department_id`, `create_date`, `update_date`, `create_by`, `update_by`, `is_publish`, `is_deleted`) VALUES
(1, '110210', 2, 'Geolocator', 'This is Description of Geolocator Course', 'Geolocator Course\r\n - location\r\n - plate\r\n - date of location', 1, 1, '2025-03-03', '2025-03-03', 1, 1, 1, 0),
(2, '110222', 3, 'Facebook Course', 'This is Description of Facebook\r\n', 'Facebook Course\r\n - social media\r\n - for entertainment', 2, 1, '2025-03-03', '2025-03-03', 3, 3, 1, 0),
(7, '123451', 4, 'Course Test', 'Description  Course Test', 'Objective Course Test', 2, 2, '2025-03-19', '2025-03-19', 3, 0, 1, 0),
(8, '101112', 1, 'Course programing', 'Course programing Description', 'Course programing Objective', 1, 1, '2025-03-19', '2025-03-19', 5, 0, 1, 0),
(9, '101010', 6, 'Thai massage', 'Thai masssage in your heart', '- relax\r\n- comfortable', 1, 2, '2025-03-19', '2025-03-19', 1, 0, 1, 0),
(10, '110220', 1, 'Instagram', 'this is course about start into instagram.\r\nnow those course you will learn about starter, create accout, post, etc', '- social media.\r\n- content on internet.\r\n- find new friend.', 2, 1, '2025-03-24', '2025-03-24', 3, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_access`
--

CREATE TABLE `course_access` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_access` tinyint(1) NOT NULL DEFAULT 0,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_access`
--

INSERT INTO `course_access` (`id`, `course_id`, `user_id`, `is_access`, `create_date`, `create_by`, `is_deleted`) VALUES
(1, 1, 2, 1, '2025-03-28', 1, 0),
(2, 2, 2, 1, '2025-03-28', 1, 0),
(3, 7, 2, 1, '2025-03-28', 1, 0),
(4, 8, 2, 1, '2025-03-28', 1, 0),
(5, 9, 2, 1, '2025-03-28', 1, 0),
(6, 10, 1, 1, '2025-03-28', 1, 0),
(7, 1, 1, 1, '2025-03-28', 1, 0),
(8, 2, 1, 1, '2025-03-28', 1, 0),
(9, 7, 1, 1, '2025-03-28', 1, 0),
(10, 8, 1, 1, '2025-03-28', 1, 0),
(11, 9, 1, 1, '2025-03-28', 1, 0),
(12, 10, 3, 1, '2025-03-28', 3, 0),
(14, 1, 3, 1, '2025-03-28', 3, 0),
(15, 2, 3, 1, '2025-03-28', 3, 0),
(16, 7, 3, 1, '2025-03-28', 3, 0),
(17, 8, 3, 1, '2025-03-28', 3, 0),
(18, 9, 3, 1, '2025-03-28', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_schedule`
--

CREATE TABLE `course_schedule` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_schedule`
--

INSERT INTO `course_schedule` (`id`, `course_id`, `day_id`, `start_time`, `end_time`, `is_deleted`) VALUES
(1, 1, 4, '09:00', '12:00', 0),
(2, 1, 3, '13:00', '16:00', 0);

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
(7, 8, 8, 14, 2, 0, '2025-03-20', '2025-03-20', 0, 0),
(44, 2, 3, 3, 2, 0, '2025-03-21', '2025-03-21', 0, 0),
(45, 2, 3, 6, 2, 0, '2025-03-21', '2025-03-21', 0, 0),
(46, 2, 4, 4, 2, 0, '2025-03-21', '2025-03-21', 0, 0),
(47, 2, 4, 5, 2, 0, '2025-03-21', '2025-03-21', 0, 0),
(52, 2, 3, 3, 1, 0, '2025-03-21', '2025-03-21', 0, 0),
(53, 2, 3, 6, 1, 0, '2025-03-21', '2025-03-21', 0, 0),
(54, 2, 4, 4, 1, 0, '2025-03-21', '2025-03-21', 0, 0),
(55, 2, 4, 5, 1, 0, '2025-03-21', '2025-03-21', 0, 0),
(56, 2, 3, 3, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(57, 2, 3, 6, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(58, 2, 4, 4, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(59, 2, 4, 5, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(60, 2, 10, 20, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(61, 10, 11, 24, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(62, 10, 11, 25, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(63, 10, 12, 26, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(64, 10, 12, 27, 3, 0, '2025-03-24', '2025-03-24', 0, 0),
(65, 10, 12, 28, 3, 0, '2025-03-24', '2025-03-24', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short_name` varchar(3) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`, `short_name`, `is_deleted`) VALUES
(1, 'Monday', 'Mon', 0),
(2, 'Tuesday', 'Tue', 0),
(3, 'Wednesday', 'Wed', 0),
(4, 'Thursday', 'Thu', 0),
(5, 'Friday', 'Fri', 0),
(6, 'Saturday', 'Sat', 0),
(7, 'Sunday', 'Sun', 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `faculty_id`, `name`, `is_deleted`) VALUES
(1, 1, 'All', 0),
(2, 1, 'Test Department 1 1', 0),
(3, 1, 'Test Department 1 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `is_deleted`) VALUES
(0, '-emtry-', 0),
(1, 'Engineer', 0),
(2, 'Science', 0);

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
  `introduction` text NOT NULL,
  `conclusion` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `course_id`, `name`, `introduction`, `conclusion`, `create_date`, `update_date`, `is_deleted`) VALUES
(1, 1, 'Geolocator Unit 1', 'Introduction Geolocator Unit 1', '', '2025-03-06', '2025-03-06', 0),
(2, 1, 'Geolocator Unit 2', 'Introduction Geolocator Unit 2', '', '2025-03-06', '2025-03-06', 0),
(3, 2, 'Facebook Course Unit 1', 'Introduction Facebook Course Unit 1', '', '2025-03-06', '2025-03-06', 0),
(4, 2, 'Facebook Course Unit 2', 'Introduction Facebook Course Unit 2', '', '2025-03-06', '2025-03-06', 0),
(7, 7, 'Header 01 of Course Test', 'Introduction Header 01 of Course Test', '', '2025-03-19', '2025-03-19', 0),
(8, 8, 'preview', 'Introduction preview', '', '2025-03-19', '2025-03-19', 0),
(9, 9, 'massage shop', 'Introduction massage shop', '', '2025-03-19', '2025-03-19', 0),
(10, 2, 'Facebook Course Unit 3', 'Introduction Facebook Course Unit 3', '', '2025-03-22', '2025-03-22', 0),
(11, 10, 'About Instagram', 'Introduction About Instagram', '', '2025-03-24', '2025-03-24', 0),
(12, 10, 'Accout', 'Introduction Accout', '', '2025-03-24', '2025-03-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `code` varchar(11) NOT NULL DEFAULT '65000000000',
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

INSERT INTO `user` (`id`, `code`, `name`, `email`, `username`, `password`, `rank`, `telephone`, `create_date`, `update_date`, `is_pushhandup`, `is_admin`, `is_deleted`) VALUES
(1, '65000000001', 'Adminitrator', 'admin@gmail.com', 'admin', 'admin', 0, '0987654321', '2025-03-03', '2025-03-03', 0, 1, 0),
(2, '65000000002', 'user', 'user@gmail.com', 'user', 'user', 1, '1234567890', '2025-03-03', '2025-03-03', 0, 0, 0),
(3, '65000000003', 'Adminitrator2', 'admin2@gmail.com', 'admin2', 'admin', 0, '0123456789', '2025-03-03', '2025-03-03', 0, 1, 0),
(5, '65000000004', 'Adminitrator2', 'admin2@gmail.com', 'admin3', 'admin', 0, '0123456789', '2025-03-03', '2025-03-03', 0, 1, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id_course__id_faculty` (`faculty_id`),
  ADD KEY `department_id_course__id_department` (`department_id`);

--
-- Indexes for table `course_access`
--
ALTER TABLE `course_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_course_access__id_course` (`course_id`),
  ADD KEY `user_id_course_access__id_user` (`user_id`);

--
-- Indexes for table `course_schedule`
--
ALTER TABLE `course_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_course_schedule__id_course` (`course_id`),
  ADD KEY `day_id_course_schedule__id_course` (`day_id`);

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
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id_department__id_faculty` (`faculty_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_access`
--
ALTER TABLE `course_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `course_schedule`
--
ALTER TABLE `course_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `department_id_course__id_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `faculty_id_course__id_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `course_access`
--
ALTER TABLE `course_access`
  ADD CONSTRAINT `course_id_course_access__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `user_id_course_access__id_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `course_schedule`
--
ALTER TABLE `course_schedule`
  ADD CONSTRAINT `course_id_course_schedule__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `day_id_course_schedule__id_course` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`);

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `content_id_course_student__id_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`),
  ADD CONSTRAINT `course_id_course_student__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `owner_id_course_student__id_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `unit_id_course_student__id_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `faculty_id_department__id_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

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
