-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lms_e_learning
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `type_id_content__id_type` (`type_id`),
  KEY `unit_id_content__id_unit` (`unit_id`),
  CONSTRAINT `type_id_content__id_type` FOREIGN KEY (`type_id`) REFERENCES `typefile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `unit_id_content__id_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,1,1,'Geo Unit 1 \r\nContent of Geo Unit 1 with Text','2025-03-06','2025-03-06',0),(2,2,1,'Geo Unit 2 \r\nContent of Geo Unit 2 with Text','2025-03-06','2025-03-06',0),(3,3,1,'adwasfasdawda','2025-03-06','2025-03-06',0),(4,4,2,'../uploads/admin/mushroom_forest.png','2025-03-06','2025-03-06',0),(5,4,3,'https://www.youtube.com/embed/EFmxPMdBqmU','2025-03-06','2025-03-06',0),(6,3,4,'../uploads/admin/Elearning_TOR.pdf','2025-03-06','2025-03-06',0),(9,7,1,'content Text of Course Test','2025-03-19','2025-03-19',0),(10,7,2,'../uploads/admin/H2522efcc054a4c71ae0e0617e01411c.jpg','2025-03-19','2025-03-19',0),(11,7,1,'mushroom glowing','2025-03-19','2025-03-19',0),(12,7,2,'../uploads/admin/mushroom_forest.png','2025-03-19','2025-03-19',0),(13,8,1,'<h2>Text ไงงง</h2>','2025-03-19','2025-03-19',0),(14,8,2,'../uploads/admin2/mushroom_forest.png','2025-03-19','2025-03-19',0),(15,9,1,'Photo environment','2025-03-19','2025-03-19',0),(16,9,1,'<h3>Room</h3>','2025-03-19','2025-03-19',0),(17,9,2,'../uploads/admin/3_รักตัวเอง-01.jpg','2025-03-19','2025-03-19',0),(18,9,1,'<h3>Employee</h3>','2025-03-19','2025-03-19',0),(19,9,2,'../uploads/admin/GhzRRSsbQAEThSp.jfif','2025-03-19','2025-03-19',0),(20,10,1,'Text Box about New content in Unit 3','2025-03-22','2025-03-22',0),(23,10,2,'../uploads/admin2/IMG_5493.JPG','2025-03-24','2025-03-24',0),(24,11,2,'../uploads/admin2/Later_Media_-_Instagram_Bio_Nov.png','2025-03-24','2025-03-24',0),(25,11,2,'../uploads/admin2/images.png','2025-03-24','2025-03-24',0),(26,12,1,'This Image','2025-03-24','2025-03-24',0),(27,12,2,'../uploads/admin2/instagram-pin-posts.png','2025-03-24','2025-03-24',0),(28,12,2,'../uploads/admin2/canva-black-and-beige-photo-new.png','2025-03-24','2025-03-24',0);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `faculty_id_course__id_faculty` (`faculty_id`),
  KEY `department_id_course__id_department` (`department_id`),
  CONSTRAINT `department_id_course__id_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  CONSTRAINT `faculty_id_course__id_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'110210',2,'Geolocator','This is Description of Geolocator Course','Geolocator Course\r\n - location\r\n - plate\r\n - date of location',1,1,'2025-03-03','2025-03-03',1,1,1,0),(2,'110222',3,'Facebook Course','This is Description of Facebook\r\n','Facebook Course\r\n - social media\r\n - for entertainment',2,1,'2025-03-03','2025-03-03',3,3,1,0),(7,'123451',4,'Course Test','Description  Course Test','Objective Course Test',2,2,'2025-03-19','2025-03-19',3,0,1,0),(8,'101112',1,'Course programing','Course programing Description','Course programing Objective',1,1,'2025-03-19','2025-03-19',5,0,1,0),(9,'101010',6,'Thai massage','Thai masssage in your heart','- relax\r\n- comfortable',1,2,'2025-03-19','2025-03-19',1,0,1,0),(10,'110220',1,'Instagram','this is course about start into instagram.\r\nnow those course you will learn about starter, create accout, post, etc','- social media.\r\n- content on internet.\r\n- find new friend.',2,1,'2025-03-24','2025-03-24',3,3,0,0);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_access`
--

DROP TABLE IF EXISTS `course_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_access` tinyint(1) NOT NULL DEFAULT 0,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id_course_access__id_course` (`course_id`),
  KEY `user_id_course_access__id_user` (`user_id`),
  CONSTRAINT `course_id_course_access__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `user_id_course_access__id_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_access`
--

LOCK TABLES `course_access` WRITE;
/*!40000 ALTER TABLE `course_access` DISABLE KEYS */;
INSERT INTO `course_access` VALUES (1,1,2,1,'2025-03-28',1,0),(2,2,2,1,'2025-03-28',1,0),(3,7,2,1,'2025-03-28',1,0),(4,8,2,1,'2025-03-28',1,0),(5,9,2,1,'2025-03-28',1,0),(6,10,1,1,'2025-03-28',1,0),(7,1,1,1,'2025-03-28',1,0),(8,2,1,1,'2025-03-28',1,0),(9,7,1,1,'2025-03-28',1,0),(10,8,1,1,'2025-03-28',1,0),(11,9,1,1,'2025-03-28',1,0),(12,10,3,1,'2025-03-28',3,0),(14,1,3,1,'2025-03-28',3,0),(15,2,3,1,'2025-03-28',3,0),(16,7,3,1,'2025-03-28',3,0),(17,8,3,1,'2025-03-28',3,0),(18,9,3,1,'2025-03-28',3,0);
/*!40000 ALTER TABLE `course_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_schedule`
--

DROP TABLE IF EXISTS `course_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id_course_schedule__id_course` (`course_id`),
  KEY `day_id_course_schedule__id_course` (`day_id`),
  CONSTRAINT `course_id_course_schedule__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `day_id_course_schedule__id_course` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_schedule`
--

LOCK TABLES `course_schedule` WRITE;
/*!40000 ALTER TABLE `course_schedule` DISABLE KEYS */;
INSERT INTO `course_schedule` VALUES (1,1,4,'09:00','12:00',0),(2,1,3,'13:00','16:00',0);
/*!40000 ALTER TABLE `course_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_student`
--

DROP TABLE IF EXISTS `course_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `point` float NOT NULL DEFAULT 0,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id_course_student__id_course` (`course_id`),
  KEY `unit_id_course_student__id_unit` (`unit_id`),
  KEY `owner_id_course_student__id_user` (`owner_id`),
  KEY `content_id_course_student__id_content` (`content_id`),
  CONSTRAINT `content_id_course_student__id_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`),
  CONSTRAINT `course_id_course_student__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `owner_id_course_student__id_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`),
  CONSTRAINT `unit_id_course_student__id_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_student`
--

LOCK TABLES `course_student` WRITE;
/*!40000 ALTER TABLE `course_student` DISABLE KEYS */;
INSERT INTO `course_student` VALUES (1,9,9,15,2,0,'2025-03-20','2025-03-20',0,0),(2,9,9,16,2,0,'2025-03-20','2025-03-20',0,0),(3,9,9,17,2,0,'2025-03-20','2025-03-20',0,0),(4,9,9,18,2,0,'2025-03-20','2025-03-20',0,0),(5,9,9,19,2,0,'2025-03-20','2025-03-20',0,0),(6,8,8,13,2,0,'2025-03-20','2025-03-20',0,0),(7,8,8,14,2,0,'2025-03-20','2025-03-20',0,0),(44,2,3,3,2,0,'2025-03-21','2025-03-21',0,0),(45,2,3,6,2,0,'2025-03-21','2025-03-21',0,0),(46,2,4,4,2,0,'2025-03-21','2025-03-21',0,0),(47,2,4,5,2,0,'2025-03-21','2025-03-21',0,0),(52,2,3,3,1,0,'2025-03-21','2025-03-21',0,0),(53,2,3,6,1,0,'2025-03-21','2025-03-21',0,0),(54,2,4,4,1,0,'2025-03-21','2025-03-21',0,0),(55,2,4,5,1,0,'2025-03-21','2025-03-21',0,0),(56,2,3,3,3,0,'2025-03-24','2025-03-24',0,0),(57,2,3,6,3,0,'2025-03-24','2025-03-24',0,0),(58,2,4,4,3,0,'2025-03-24','2025-03-24',0,0),(59,2,4,5,3,0,'2025-03-24','2025-03-24',0,0),(60,2,10,20,3,0,'2025-03-24','2025-03-24',0,0),(61,10,11,24,3,0,'2025-03-24','2025-03-24',0,0),(62,10,11,25,3,0,'2025-03-24','2025-03-24',0,0),(63,10,12,26,3,0,'2025-03-24','2025-03-24',0,0),(64,10,12,27,3,0,'2025-03-24','2025-03-24',0,0),(65,10,12,28,3,0,'2025-03-24','2025-03-24',0,0),(66,1,1,1,1,0,'2025-04-04','2025-04-04',0,0),(67,1,2,2,1,0,'2025-04-04','2025-04-04',0,0),(68,1,1,1,2,0,'2025-04-04','2025-04-04',0,0),(69,1,2,2,2,0,'2025-04-04','2025-04-04',0,0),(70,1,1,1,3,0,'2025-04-04','2025-04-04',0,0),(71,1,2,2,3,0,'2025-04-04','2025-04-04',0,0),(72,1,1,1,5,0,'2025-04-04','2025-04-04',0,0),(73,1,2,2,5,0,'2025-04-04','2025-04-04',0,0);
/*!40000 ALTER TABLE `course_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `short_name` varchar(3) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES (1,'Monday','Mon',0),(2,'Tuesday','Tue',0),(3,'Wednesday','Wed',0),(4,'Thursday','Thu',0),(5,'Friday','Fri',0),(6,'Saturday','Sat',0),(7,'Sunday','Sun',0);
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `faculty_id_department__id_faculty` (`faculty_id`),
  CONSTRAINT `faculty_id_department__id_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,1,'All',0),(2,1,'Test Department 1 1',0),(3,1,'Test Department 1 2',0);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (0,'-emtry-',0),(1,'Engineer',0),(2,'Science',0);
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `filepath` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `content_id_file__id_content` (`content_id`),
  CONSTRAINT `content_id_file__id_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_error`
--

DROP TABLE IF EXISTS `log_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `username` varchar(255) DEFAULT 'guest',
  `ip_address` varchar(45) DEFAULT 'unknown',
  `user_agent` text DEFAULT 'unknown',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_error`
--

LOCK TABLES `log_error` WRITE;
/*!40000 ALTER TABLE `log_error` DISABLE KEYS */;
INSERT INTO `log_error` VALUES (1,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:42:02'),(2,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:43:17'),(3,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:43:44'),(4,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 08:43:17');
/*!40000 ALTER TABLE `log_error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_login`
--

DROP TABLE IF EXISTS `log_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `action` enum('login','logout','login_failed') DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `log_time` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_login`
--

LOCK TABLES `log_login` WRITE;
/*!40000 ALTER TABLE `log_login` DISABLE KEYS */;
INSERT INTO `log_login` VALUES (1,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:34:59'),(2,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:39'),(3,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:51'),(4,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:58'),(5,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:53:53'),(6,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:53:59'),(7,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:55:05');
/*!40000 ALTER TABLE `log_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typefile`
--

DROP TABLE IF EXISTS `typefile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typefile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typefile`
--

LOCK TABLES `typefile` WRITE;
/*!40000 ALTER TABLE `typefile` DISABLE KEYS */;
INSERT INTO `typefile` VALUES (1,'Text Box','2025-03-06','2025-03-06',0),(2,'Image','2025-03-06','2025-03-06',0),(3,'Video','2025-03-06','2025-03-06',0),(4,'PDF','2025-03-06','2025-03-06',0);
/*!40000 ALTER TABLE `typefile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `introduction` text NOT NULL,
  `conclusion` text NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id_unit__id_course` (`course_id`),
  CONSTRAINT `course_id_unit__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,1,'Geolocator Unit 1','Introduction Geolocator Unit 1','','2025-03-06','2025-03-06',0),(2,1,'Geolocator Unit 2','Introduction Geolocator Unit 2','','2025-03-06','2025-03-06',0),(3,2,'Facebook Course Unit 1','Introduction Facebook Course Unit 1','','2025-03-06','2025-03-06',0),(4,2,'Facebook Course Unit 2','Introduction Facebook Course Unit 2','','2025-03-06','2025-03-06',0),(7,7,'Header 01 of Course Test','Introduction Header 01 of Course Test','','2025-03-19','2025-03-19',0),(8,8,'preview','Introduction preview','','2025-03-19','2025-03-19',0),(9,9,'massage shop','Introduction massage shop','','2025-03-19','2025-03-19',0),(10,2,'Facebook Course Unit 3','Introduction Facebook Course Unit 3','','2025-03-22','2025-03-22',0),(11,10,'About Instagram','Introduction About Instagram','','2025-03-24','2025-03-24',0),(12,10,'Accout','Introduction Accout','','2025-03-24','2025-03-24',0);
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'65000000001','Jirawat Sisaard Reef','Jirawat@gmail.com','admin','admin',0,'0987654321','2025-03-03','2025-03-03',0,1,0),(2,'65000000002','Newbie olded gika','newbie@gmail.com','user','user',1,'0984634583','2025-04-04','2025-04-04',0,0,0),(3,'65000000003','Bancha Siripapan Jet','Bancha@gmail.com','Bancha.S.Admin','admin',0,'0123456789','2025-03-03','2025-03-03',0,1,0),(5,'65000000004','Kanya Sukseree Queen','Kanya@gmail.com','Kanya.S.Admin','admin',0,'0123456789','2025-03-03','2025-04-03',0,1,0),(6,'65000000005','Nichaporn Treesup Cha-em','Nichaporn@gmail.com','Nichaporn.T.User','1234',0,'123456789','2025-04-03','2025-04-03',0,0,0),(8,'65000000006','Peeraya Tarawong Gigiasd','Peeraya@gmail.coms','Peeraya.T.User','1234',1,'1234567890','2025-03-03','2025-04-03',0,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-05 16:33:23