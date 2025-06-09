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
-- Table structure for table `chat_access`
--

DROP TABLE IF EXISTS `chat_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `chat_room_id__fk` (`chat_room_id`),
  KEY `user_id_fk` (`user_id`),
  CONSTRAINT `chat_room_id__fk` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`),
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_access`
--

LOCK TABLES `chat_access` WRITE;
/*!40000 ALTER TABLE `chat_access` DISABLE KEYS */;
INSERT INTO `chat_access` VALUES (1,1,1,0),(2,2,1,0),(3,1,2,0),(4,2,3,0),(9,1,3,0),(10,1,5,0),(15,5,2,0),(16,5,6,0),(17,6,1,0),(18,6,5,0);
/*!40000 ALTER TABLE `chat_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `chat_room_id` (`chat_room_id`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (21,1,'This is Chat 2',2,'2025-04-17 07:33:31'),(22,1,'Test Chat in 2 box',2,'2025-04-17 07:39:47'),(23,1,'Chat box 2',2,'2025-04-17 07:40:37'),(29,1,'Im admin1 ',1,'2025-04-25 04:14:58'),(30,2,'Hi im user',1,'2025-04-25 04:15:06'),(31,3,'im admin too',1,'2025-04-25 04:15:19'),(32,5,'im admin three',1,'2025-04-25 04:15:28'),(33,1,'i think you the best',1,'2025-04-25 04:18:09'),(34,1,'Hi',1,'2025-04-25 10:21:20'),(35,2,'Hellp',1,'2025-04-25 10:21:30'),(36,1,'I want to know how long message for show in example box',1,'2025-04-28 06:33:40'),(37,2,'Hola',5,'2025-04-28 09:27:25'),(38,2,'สวัสดี',1,'2025-06-03 08:21:45');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_rooms`
--

DROP TABLE IF EXISTS `chat_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_rooms`
--

LOCK TABLES `chat_rooms` WRITE;
/*!40000 ALTER TABLE `chat_rooms` DISABLE KEYS */;
INSERT INTO `chat_rooms` VALUES (1,'Science 1/2568','2025-04-17 02:30:01','2025-05-24 01:56:32',0),(2,'Bancha Siripapan Jet','2025-04-17 02:30:01','2025-06-05 04:49:13',0),(5,'new_chat[26]','2025-04-28 09:27:16','2025-04-28 09:27:16',0),(6,'Kanya Sukseree Queen','2025-05-24 02:49:54','2025-06-05 04:49:00',0);
/*!40000 ALTER TABLE `chat_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choices`
--

DROP TABLE IF EXISTS `choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `choice_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choices`
--

LOCK TABLES `choices` WRITE;
/*!40000 ALTER TABLE `choices` DISABLE KEYS */;
INSERT INTO `choices` VALUES (1,1,'sqrt(6)',0),(2,1,'2 + 2 - 2',1),(3,1,'4 x 4 / 4',0),(4,1,'6 - 2 + (-4 - 2)',0),(5,2,'2 % 0',0),(6,2,'1 + 1 = 2',1),(7,2,'3 - 1',0),(8,2,'5 - 3',0),(9,3,'980',0),(10,3,'1080',1),(11,3,'1180',0),(12,3,'1280',0),(13,4,'A = 2 B = 1 C = 3',0),(14,4,'B = 2 A = 3 C = 2',0),(15,4,'B = 2 C = 1 A = 3',1),(16,4,'A = 2 B = 1 C = 1',0),(17,5,'7',1),(18,5,'70',0),(19,5,'700',0),(20,5,'Not choice is correct',0),(21,6,'together',0),(22,6,'Add',1),(23,6,'sum',0),(24,6,'all choice',0),(25,7,'ต้นไม้',1),(26,7,'สาม',0),(27,7,'พยัญชนะภาษาอังกฤษ',0),(28,7,'T',0),(29,8,'สอง',0),(30,8,'เช่นกัน',1),(31,8,'สวนสัตว์',0),(32,8,'เครื่องมือ',0),(33,9,'ระบบปฏิบัติการสำหรับเซิร์ฟเวอร์',0),(34,9,'ภาษาโปรแกรมที่ใช้งานง่ายและได้รับความนิยม',1),(35,9,'โปรแกรมตัดต่อวิดีโอ',0),(36,9,'เบราว์เซอร์สำหรับเขียนเว็บไซต์',0),(37,10,'.html',0),(38,10,'.js',0),(39,10,'.py',1),(40,10,'.png',0);
/*!40000 ALTER TABLE `choices` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,1,1,'Geo Unit 1 \r\nContent of Geo Unit 1 with Text','2025-03-06','2025-03-06',0),(2,2,1,'Geo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with TextGeo Unit 2 Content of Geo Unit 2 with Text','2025-03-06','2025-03-06',0),(3,3,1,'adwasfasdawda','2025-03-06','2025-03-06',0),(4,4,2,'../uploads/admin/mushroom_forest.png','2025-03-06','2025-03-06',0),(5,4,3,'https://www.youtube.com/embed/EFmxPMdBqmU','2025-03-06','2025-03-06',0),(6,3,4,'../uploads/admin/Elearning_TOR.pdf','2025-03-06','2025-03-06',0),(9,7,1,'content Text of Course Test','2025-03-19','2025-03-19',0),(10,7,2,'../uploads/admin/H2522efcc054a4c71ae0e0617e01411c.jpg','2025-03-19','2025-03-19',0),(11,7,1,'mushroom glowing','2025-03-19','2025-03-19',0),(12,7,2,'../uploads/admin/mushroom_forest.png','2025-03-19','2025-03-19',0),(13,8,1,'ตัวอย่างข้อความภาษาไทย / English language text example','2025-03-19','2025-03-19',0),(14,8,2,'../uploads/admin2/mushroom_forest.png','2025-03-19','2025-03-19',0),(15,9,1,'Photo environment','2025-03-19','2025-03-19',0),(16,9,1,'<h3>Room</h3>','2025-03-19','2025-03-19',0),(17,9,2,'../uploads/admin/3_รักตัวเอง-01.jpg','2025-03-19','2025-03-19',0),(18,9,1,'<h3>Employee</h3>','2025-03-19','2025-03-19',0),(19,9,2,'../uploads/admin/GhzRRSsbQAEThSp.jfif','2025-03-19','2025-03-19',0),(20,10,1,'Text Box about New content in Unit 3','2025-03-22','2025-03-22',0),(23,10,2,'../uploads/admin2/IMG_5493.JPG','2025-03-24','2025-03-24',0),(24,11,2,'../uploads/admin2/Later_Media_-_Instagram_Bio_Nov.png','2025-03-24','2025-03-24',0),(25,11,2,'../uploads/admin2/images.png','2025-03-24','2025-03-24',0),(26,12,1,'This Image','2025-03-24','2025-03-24',0),(27,12,2,'../uploads/admin2/instagram-pin-posts.png','2025-03-24','2025-03-24',0),(28,12,2,'../uploads/admin2/canva-black-and-beige-photo-new.png','2025-03-24','2025-03-24',0),(30,2,5,'https://kahoot.it/125213','2025-04-21','2025-04-21',0),(31,2,5,'https://kahoot.it/','2025-04-21','2025-04-21',1),(32,2,6,'../uploads/admin/Spanner.glb','2025-04-23','2025-04-23',0),(33,2,6,'../uploads/admin/uploads_files_2426738_tex.gltf','2025-04-23','2025-04-23',1),(34,2,7,'3_Science Math','2025-04-29','2025-04-29',0),(35,2,7,'4_post Math','2025-05-02','2025-05-02',0),(36,2,7,'5_Quiz midterm','2025-05-02','2025-05-02',0),(37,13,1,'ตัวอย่างข้อความภาษาไทย / English language text example','2025-05-23','2025-05-23',0),(38,14,2,'../uploads/admin/python-programming-language.png','2025-05-24','2025-05-24',0),(39,14,1,'Python เป็นภาษาการเขียนโปรแกรมที่ใช้อย่างแพร่หลายในเว็บแอปพลิเคชัน การพัฒนาซอฟต์แวร์ วิทยาศาสตร์ข้อมูล และแมชชีนเลิร์นนิง (ML) นักพัฒนาใช้ Python เนื่องจากมีประสิทธิภาพ เรียนรู้ง่าย และสามารถทำงานบนแพลตฟอร์มต่างๆ ได้มากมาย ทั้งนี้ซอฟต์แวร์ Python สามารถดาวน์โหลดได้ฟรี ผสานการทำงานร่วมกับระบบทุกประเภท และเพิ่มความเร็วในการพัฒนา','2025-05-24','2025-05-24',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'110210',2,'Geolocator','This is Description of Geolocator Course','Geolocator Course\r\n - location\r\n - plate\r\n - date of location',1,1,'2025-03-03','2025-03-03',1,1,1,0),(2,'110222',3,'Facebook Course','This is Description of Facebook\r\n','Facebook Course\r\n - social media\r\n - for entertainment',2,1,'2025-03-03','2025-03-03',3,3,1,0),(7,'123451',4,'Course Test','Description  Course Test','Objective Course Test',4,1,'2025-03-19','2025-03-19',3,0,1,0),(8,'101112',1,'Programming fundamentals','Programming fundamentals description','programming fundamentals Objective',1,1,'2025-03-19','2025-03-19',1,1,1,0),(9,'101010',6,'Thai massage','Thai masssage in your heart','- relax\r\n- comfortable',1,2,'2025-03-19','2025-03-19',1,0,1,0),(10,'110220',1,'Instagram','this is course about start into instagram.\r\nnow those course you will learn about starter, create accout, post, etc','- social media.\r\n- content on internet.\r\n- find new friend.',2,1,'2025-03-24','2025-03-24',3,3,0,0),(12,'110210',1,'เริ่มต้นเขียนโปรแกรมด้วย Python สำหรับผู้เริ่มต้น','คอร์สนี้ออกแบบมาสำหรับผู้ไม่มีพื้นฐานด้านการเขียนโปรแกรม โดยใช้ภาษา Python ซึ่งเป็นภาษาที่เรียนรู้ง่าย มีโครงสร้างที่เข้าใจง่ายและนิยมใช้ทั่วโลก ผู้เรียนจะได้เรียนรู้ตั้งแต่แนวคิดพื้นฐานของการเขียนโปรแกรม การใช้งานตัวแปร เงื่อนไข การวนลูป ฟังก์ชัน ไปจนถึงการเขียนโปรแกรมอย่างเป็นระบบ พร้อมแบบฝึกหัดเพื่อเสริมทักษะ','เข้าใจแนวคิดเบื้องต้นเกี่ยวกับการเขียนโปรแกรม\r\n\r\nเขียนโปรแกรมเบื้องต้นด้วยภาษา Python ได้\r\n\r\nแก้ปัญหาโดยใช้การเขียนโปรแกรม\r\n\r\nฝึกฝนแนวคิดเชิงตรรกะและขั้นตอนการคิดเป็นลำดับ\r\n\r\nเตรียมความพร้อมสู่การเรียนรู้ขั้นสูงหรือการพัฒนาโปรเจกต์จริง',1,1,'2025-05-24','2025-05-24',1,1,1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_access`
--

LOCK TABLES `course_access` WRITE;
/*!40000 ALTER TABLE `course_access` DISABLE KEYS */;
INSERT INTO `course_access` VALUES (1,1,2,1,'2025-03-28',1,0),(2,2,2,1,'2025-03-28',1,0),(3,7,2,1,'2025-03-28',1,0),(4,8,2,1,'2025-03-28',1,0),(5,9,2,1,'2025-03-28',1,0),(6,10,1,1,'2025-03-28',1,0),(7,1,1,1,'2025-03-28',1,0),(8,2,1,1,'2025-03-28',1,0),(9,7,1,1,'2025-03-28',1,0),(10,8,1,1,'2025-03-28',1,0),(11,9,1,1,'2025-03-28',1,0),(12,10,3,1,'2025-03-28',3,0),(14,1,3,1,'2025-03-28',3,0),(15,2,3,1,'2025-03-28',3,0),(16,7,3,1,'2025-03-28',3,0),(17,8,3,1,'2025-03-28',3,0),(18,9,3,1,'2025-03-28',3,0),(20,12,1,1,'2025-03-28',1,0),(21,12,2,1,'2025-03-28',1,0),(22,12,3,0,'2025-06-04',0,0),(23,12,5,0,'2025-06-04',0,0),(24,12,6,0,'2025-06-04',0,0),(25,12,8,0,'2025-06-04',0,0);
/*!40000 ALTER TABLE `course_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_points`
--

DROP TABLE IF EXISTS `course_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `point` float NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `exam_id` (`exam_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `course_points_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `course_points_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `course_points_ibfk_3` FOREIGN KEY (`exam_id`) REFERENCES `question_sets` (`id`),
  CONSTRAINT `course_points_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_points`
--

LOCK TABLES `course_points` WRITE;
/*!40000 ALTER TABLE `course_points` DISABLE KEYS */;
INSERT INTO `course_points` VALUES (1,1,1,2,3,1,2),(3,2,1,2,3,0,0),(8,1,1,2,4,3,4),(9,2,1,2,4,0,0),(10,1,1,2,5,2,2),(11,2,1,2,5,0,0);
/*!40000 ALTER TABLE `course_points` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_schedule`
--

LOCK TABLES `course_schedule` WRITE;
/*!40000 ALTER TABLE `course_schedule` DISABLE KEYS */;
INSERT INTO `course_schedule` VALUES (1,1,3,'09:00','12:00',0),(2,1,2,'13:00','16:00',0),(3,2,4,'08:00','11:00',0),(4,2,5,'13:00','16:00',0),(5,12,1,'09:00','12:00',0);
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
  `owner_id` int(11) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id_course_student__id_course` (`course_id`),
  KEY `owner_id_course_student__id_user` (`owner_id`),
  CONSTRAINT `course_id_course_student__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `owner_id_course_student__id_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_student`
--

LOCK TABLES `course_student` WRITE;
/*!40000 ALTER TABLE `course_student` DISABLE KEYS */;
INSERT INTO `course_student` VALUES (103,1,1,'2025-05-02','2025-05-02',0,0),(105,1,2,'2025-05-02','2025-05-02',0,0),(106,2,1,'2025-05-02','2025-05-02',0,0);
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
INSERT INTO `days` VALUES (1,'monday','Mon',0),(2,'tuesday','Tue',0),(3,'wednesday','Wed',0),(4,'thursday','Thu',0),(5,'friday','Fri',0),(6,'saturday','Sat',0),(7,'sunday','Sun',0);
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
INSERT INTO `department` VALUES (1,1,'All',0),(2,2,'Computer Science',0),(3,2,'Mathematics',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (0,'-emtry-',0),(1,'all faculty',0),(2,'science',0),(4,'engineering',0);
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
-- Table structure for table `log_action`
--

DROP TABLE IF EXISTS `log_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `username` varchar(255) DEFAULT 'guest',
  `ip_address` varchar(45) DEFAULT 'unknown',
  `user_agent` text DEFAULT 'unknown',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action`
--

LOCK TABLES `log_action` WRITE;
/*!40000 ALTER TABLE `log_action` DISABLE KEYS */;
INSERT INTO `log_action` VALUES (5,'general','Create examination Failed: Column count doesn\'t match value count at row 1','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-07 10:39:23'),(6,'general','Create examination success.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-07 10:40:50'),(7,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 08:38:42'),(8,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 08:40:17'),(9,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 09:08:42'),(10,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 01:50:35'),(11,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 04:24:16'),(12,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 04:57:00'),(13,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-18 04:04:46'),(14,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-18 06:20:41'),(15,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-18 07:51:31'),(16,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-19 02:31:51'),(17,'general','[user] Login successful.','user','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 02:39:29'),(18,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 03:31:32'),(19,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 04:09:50'),(20,'general','[user] Login successful.','user','192.168.1.108','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 09:24:21'),(21,'general','[user] Login successful.','user','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 09:37:47'),(22,'general','adminAn unknown user attempted to access the account.','guest','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 10:08:35'),(23,'general','[admin] Login successful.','admin','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 10:08:41'),(24,'general','[user] Login successful.','user','49.237.40.220','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-20 20:56:02'),(25,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-21 18:28:01'),(26,'general','[user] Login successful.','user','49.237.6.13','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-21 18:43:51'),(27,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 08:06:05'),(28,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 08:10:17'),(29,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 08:13:48'),(30,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 08:43:53'),(31,'general','[user] Login successful.','user','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-24 02:31:41'),(32,'general','[admin] Login successful.','admin','100.125.232.88','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-24 10:17:07'),(33,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-25 04:11:54'),(34,'general','[Bancha.S.Admin] Login successful.','Bancha.S.Admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-25 04:12:48'),(35,'general','[Kanya.S.Admin] Login successful.','Kanya.S.Admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-25 04:13:25'),(36,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-28 02:40:07'),(37,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-28 09:14:57'),(38,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-29 01:59:50'),(39,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 01:42:38'),(40,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 03:27:36'),(41,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 06:55:28'),(42,'general','Create examination success.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 07:04:35'),(43,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 07:55:40'),(44,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 07:56:18'),(45,'general','Create examination success.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 08:02:15'),(46,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 08:11:49'),(47,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 08:27:19'),(48,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 10:02:28'),(49,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 10:10:38'),(50,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-03 01:44:07'),(51,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-03 01:46:15'),(52,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 06:45:34'),(53,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 06:49:57'),(54,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 08:27:27'),(55,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 08:28:05'),(56,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 08:28:37'),(57,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 08:29:29'),(58,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 08:52:00'),(59,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 09:34:20'),(60,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 10:13:20'),(61,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 03:14:39'),(62,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 09:26:22'),(63,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 09:32:21'),(64,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 09:33:42'),(65,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 09:38:07'),(66,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:01:32'),(67,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:04:53'),(68,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:06:58'),(69,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:15:56'),(70,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:23:06'),(71,'general','userAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 01:41:19'),(72,'general','userAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 01:41:26'),(73,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 01:41:32'),(74,'general','[user] Login successful.','user','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 02:03:46'),(75,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 04:47:42'),(76,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 08:28:32'),(77,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 09:55:24'),(78,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-22 02:35:12'),(79,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-22 07:54:37'),(80,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 04:15:40'),(81,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 04:15:56'),(82,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-24 01:49:38'),(83,'general','Create examination success.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-24 07:58:44'),(84,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 02:57:52'),(85,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 06:10:07'),(86,'general','[user] Login successful.','user','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 08:07:26'),(87,'general','[user] Login successful.','user','49.230.181.53','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 08:21:08'),(88,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:05:33'),(89,'general','adminAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 07:18:20'),(90,'general','adminAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 07:18:46'),(91,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:21:27'),(92,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:21:27'),(93,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:22:24'),(94,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:22:24'),(95,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-05 03:51:50'),(96,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-05 03:51:50'),(97,'general','[admin] Login successful.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-09 07:32:31'),(98,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-09 07:32:31');
/*!40000 ALTER TABLE `log_action` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_error`
--

LOCK TABLES `log_error` WRITE;
/*!40000 ALTER TABLE `log_error` DISABLE KEYS */;
INSERT INTO `log_error` VALUES (1,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:42:02'),(2,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:43:17'),(3,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 07:43:44'),(4,'export','การ export database ล้มเหลว (code: 1)','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 08:43:17'),(5,'general','Column count doesn\'t match value count at row 1','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-07 10:39:23'),(6,'general','adminAn unknown user attempted to access the account.','guest','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 10:08:35'),(7,'general','userAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 01:41:19'),(8,'general','userAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 01:41:26'),(9,'general','adminAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 07:18:21'),(10,'general','adminAn unknown user attempted to access the account.','guest','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 07:18:46'),(11,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:21:27'),(12,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 07:22:24'),(13,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-05 03:51:50'),(14,'general','adminAn unknown user attempted to access the account.','admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-09 07:32:31');
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
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_login`
--

LOCK TABLES `log_login` WRITE;
/*!40000 ALTER TABLE `log_login` DISABLE KEYS */;
INSERT INTO `log_login` VALUES (1,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:34:59'),(2,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:39'),(3,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:51'),(4,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-04 15:40:58'),(5,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:53:53'),(6,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:53:59'),(7,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','2025-04-05 10:55:05'),(8,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 15:26:40'),(9,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 15:38:42'),(10,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 15:40:07'),(11,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 15:40:17'),(12,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-11 16:08:42'),(13,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 08:50:35'),(14,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 11:24:16'),(15,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-17 11:57:00'),(16,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-18 11:04:46'),(17,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-18 13:20:41'),(18,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-18 14:51:31'),(19,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-19 09:31:51'),(20,2,'user','login','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 09:39:29'),(21,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 10:31:32'),(22,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 11:09:50'),(23,2,'user','login','192.168.1.108','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 16:24:21'),(24,2,'user','login','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 16:37:47'),(25,0,'admin','login_failed','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 17:08:35'),(26,1,'admin','login','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-19 17:08:41'),(27,2,'user','login','49.237.40.220','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-21 03:56:02'),(28,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-22 01:28:01'),(29,2,'user','login','49.237.6.13','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-22 01:43:51'),(30,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 15:06:05'),(31,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 15:10:17'),(32,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 15:13:48'),(33,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-23 15:43:53'),(34,2,'user','login','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-24 09:31:41'),(35,1,'admin','login','100.125.232.88','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-24 17:17:07'),(36,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-25 11:11:54'),(37,3,'Bancha.S.Admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-25 11:12:48'),(38,5,'Kanya.S.Admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0','2025-04-25 11:13:25'),(39,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-28 09:40:07'),(40,1,'admin','logout','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36','2025-04-28 16:14:48'),(41,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-28 16:14:57'),(42,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-29 08:59:46'),(43,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-04-29 08:59:50'),(44,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 08:42:38'),(45,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 10:27:32'),(46,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 10:27:36'),(47,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 13:55:24'),(48,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 13:55:28'),(49,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 14:55:33'),(50,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 14:55:40'),(51,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 14:56:13'),(52,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 14:56:18'),(53,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 15:11:46'),(54,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 15:11:49'),(55,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 15:27:15'),(56,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 15:27:19'),(57,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 16:50:13'),(58,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 17:02:28'),(59,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 17:02:37'),(60,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-02 17:10:38'),(61,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-03 08:44:07'),(62,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-03 08:46:08'),(63,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-03 08:46:15'),(64,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 13:45:34'),(65,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 13:45:44'),(66,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 13:49:57'),(67,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:07:22'),(68,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:27:27'),(69,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:28:05'),(70,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:28:33'),(71,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:28:37'),(72,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:28:41'),(73,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:29:29'),(74,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:51:56'),(75,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 15:52:00'),(76,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 16:34:12'),(77,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 16:34:20'),(78,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 17:13:17'),(79,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','2025-05-06 17:13:20'),(80,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 10:14:39'),(81,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:26:15'),(82,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:26:22'),(83,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:32:21'),(84,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:33:33'),(85,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:33:42'),(86,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 16:38:07'),(87,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 17:01:32'),(88,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 17:04:53'),(89,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 17:06:58'),(90,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 17:15:56'),(91,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-19 17:23:06'),(92,0,'user','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 08:41:19'),(93,0,'user','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 08:41:26'),(94,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 08:41:32'),(95,2,'user','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 09:03:46'),(96,2,'user','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 11:46:21'),(97,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-20 11:47:42'),(98,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 15:21:35'),(99,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 15:28:32'),(100,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 16:25:03'),(101,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-21 16:55:24'),(102,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-22 09:35:12'),(103,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-22 14:27:30'),(104,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-22 14:54:37'),(105,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 11:15:36'),(106,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 11:15:40'),(107,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 11:15:50'),(108,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-23 11:15:56'),(109,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2025-05-24 08:49:38'),(110,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 09:57:52'),(111,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 13:10:07'),(112,2,'user','login','49.0.69.152','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 15:07:26'),(113,2,'user','login','49.230.181.53','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-03 15:21:08'),(114,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 12:54:32'),(115,1,'admin','login','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:05:33'),(116,1,'admin','logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 14:11:32'),(117,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 14:18:20'),(118,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-04 14:18:46'),(119,1,'admin','login','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:21:27'),(120,0,'admin','login_failed','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:21:27'),(121,1,'admin','logout','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:21:54'),(122,1,'admin','login','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:22:24'),(123,0,'admin','login_failed','::1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36','2025-06-04 14:22:24'),(124,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-05 10:51:50'),(125,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-05 10:51:50'),(126,1,'admin','login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-09 14:32:31'),(127,0,'admin','login_failed','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','2025-06-09 14:32:31');
/*!40000 ALTER TABLE `log_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_sets`
--

DROP TABLE IF EXISTS `question_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` enum('pre-test','post-test','quiz') NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `exam_period` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_sets`
--

LOCK TABLES `question_sets` WRITE;
/*!40000 ALTER TABLE `question_sets` DISABLE KEYS */;
INSERT INTO `question_sets` VALUES (3,'Science Math','pre-test','prepare test before learning.','2025-04-04 17:40:00',60,'2025-04-07 17:40:41',0),(4,'post Math','post-test','this is last exam for term will be more...','2025-05-02 13:57:00',30,'2025-05-02 14:04:25',0),(5,'Quiz midterm','quiz','Quiz midterm Description.','2025-05-02 15:00:00',10,'2025-05-02 15:02:15',0),(6,'python Test','pre-test','แบบทดสอบความรู้เกี่ยวกับภาษา python สำหรับผู้เริ่มต้น','2025-05-31 14:45:00',10,'2025-05-24 14:58:44',0);
/*!40000 ALTER TABLE `question_sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_set_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('single_choice','multiple_choice','true_false','short_answer') DEFAULT 'multiple_choice',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `question_set_id` (`question_set_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`question_set_id`) REFERENCES `question_sets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,3,'What choice is correct?','multiple_choice','2025-04-07 17:40:46'),(2,3,' 1 + 1 / 1 = ?','multiple_choice','2025-04-29 14:16:17'),(3,4,'490 + 590','multiple_choice','2025-05-02 14:04:28'),(4,4,'what is A if B<A but A > C and B != C','multiple_choice','2025-05-02 14:04:35'),(5,4,'700/100 = ?','multiple_choice','2025-05-02 14:04:35'),(6,4,'what is plus (+)? ','multiple_choice','2025-05-02 14:04:35'),(7,5,'tree','multiple_choice','2025-05-02 15:02:15'),(8,5,'Too','multiple_choice','2025-05-02 15:02:15'),(9,6,'python คืออะไร?','multiple_choice','2025-05-24 14:58:44'),(10,6,'ข้อใดคือไฟล์นามสกุลที่ใช้สำหรับเขียนโปรแกรมภาษา Python?','multiple_choice','2025-05-24 14:58:44');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_set_id` int(11) NOT NULL,
  `score` float DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `question_set_id` (`question_set_id`),
  CONSTRAINT `test_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `test_results_ibfk_2` FOREIGN KEY (`question_set_id`) REFERENCES `question_sets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_line`
--

DROP TABLE IF EXISTS `token_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_line`
--

LOCK TABLES `token_line` WRITE;
/*!40000 ALTER TABLE `token_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `token_line` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typefile`
--

LOCK TABLES `typefile` WRITE;
/*!40000 ALTER TABLE `typefile` DISABLE KEYS */;
INSERT INTO `typefile` VALUES (1,'Text Box','2025-03-06','2025-03-06',0),(2,'Image','2025-03-06','2025-03-06',0),(3,'Video','2025-03-06','2025-03-06',0),(4,'PDF','2025-03-06','2025-03-06',0),(5,'Activity','2025-04-21','2025-04-21',0),(6,'3D model','2025-04-21','2025-04-21',0),(7,'Examination / Quiz','2025-04-29','2025-04-29',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,1,'Geolocator Unit 1','Introduction Geolocator Unit 1','conclusion of Geolocator Unit 1','2025-03-06','2025-03-06',0),(2,1,'Geolocator Unit 2','Introduction Geolocator Unit 2','conclusion of Geolocator Unit 2','2025-03-06','2025-03-06',0),(3,2,'Facebook Course Unit 1','Introduction Facebook Course Unit 1','conclusion of Facebook Course Unit 1','2025-03-06','2025-03-06',0),(4,2,'Facebook Course Unit 2','Introduction Facebook Course Unit 2','conclusion of Facebook Course Unit 2','2025-03-06','2025-03-06',0),(7,7,'Header 01 of Course Test','Introduction Header 01 of Course Test','conclusion of Header 01 of Course Test','2025-03-19','2025-03-19',0),(8,8,'Introduction','Introduction programming fundamentals','conclusion of Introduction in programming fundamentals','2025-03-19','2025-03-19',0),(9,9,'massage shop','Introduction massage shop','conclusion of massage shop','2025-03-19','2025-03-19',0),(10,2,'Facebook Course Unit 3','Introduction Facebook Course Unit 3','conclusion of Facebook Course Unit 3','2025-03-22','2025-03-22',0),(11,10,'About Instagram','Introduction About Instagram','conclusion of About Instagram','2025-03-24','2025-03-24',0),(12,10,'Accout','Introduction Account','conclusion of Account','2025-03-24','2025-03-24',0),(13,8,'เนื้อหาบทเรียน','','','2025-05-23','2025-05-23',0),(14,12,'ทำความรู้จักกับ Python และพื้นฐานการเขียนโปรแกรม','เริ่มต้นด้วยการทำความเข้าใจว่า \"Python\" คืออะไร ทำไมถึงได้รับความนิยม และการตั้งค่าเครื่องมือในการเริ่มเขียนโปรแกรม','ผู้เรียนสามารถติดตั้ง Python, ใช้โปรแกรมเขียนโค้ด และเข้าใจแนวคิดเบื้องต้นของคำสั่งและโครงสร้างภาษา','2025-05-24','2025-05-24',0);
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
  `password` varchar(255) NOT NULL,
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
INSERT INTO `user` VALUES (1,'65000000001','Jirawat Sisaard Reef','Jirawat@gmail.com','admin','$2y$10$5ugU0G0PNItAUaXvYByCluOgBAeHtYOxJYsRzkAoXRI7qvDMfBLcC',0,'0987654321','2025-03-03','2025-06-04',0,1,0),(2,'65000000002','Newbie olded gika','newbie@gmail.com','user','$2y$10$wslMcLnILqmTeUYJQVFkReFv9P3AExaWnanXAWl9LSa0pd39tNQhC',1,'0984634583','2025-04-04','2025-06-04',0,0,0),(3,'65000000003','Bancha Siripapan Jet','Bancha@gmail.com','Bancha.S.Admin','$2y$10$TE7aLS1.L4BpjYycEjMeUO8m6YVOZKnRsK/iY70lXi8At0QgYk/T6',0,'0123456789','2025-03-03','2025-06-04',0,1,0),(5,'65000000004','Kanya Sukseree Queen','Kanya@gmail.com','Kanya.S.Admin','$2y$10$cII.h9R/RjoXOSjDLs4PauxcARXZHAH2lPQnaaYP6fTUla4hbW15C',0,'0123456789','2025-03-03','2025-06-04',0,1,0),(6,'65000000005','Nichaporn Treesup Cha-em','Nichaporn@gmail.com','Nichaporn.T.User','$2y$10$5Dr9lTvpxyFVSrDvz6mHFOKE88qJL7biGKBpDuV/H0vQp86qEJTaC',0,'123456789','2025-04-03','2025-06-04',0,0,0),(8,'65000000006','Peeraya Tarawong Gigiasd','Peeraya@gmail.com','User','$2y$10$w6ykASpTJWbnd03yT0GTM.i5LvK0shFPRSQzyVGWI3MFAfjONerJK',1,'1234567890','2025-03-03','2025-06-04',0,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `answered_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `question_id` (`question_id`),
  KEY `choice_id` (`choice_id`),
  KEY `exam_id` (`exam_id`),
  CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `user_answers_ibfk_3` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`),
  CONSTRAINT `user_answers_ibfk_4` FOREIGN KEY (`exam_id`) REFERENCES `question_sets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_answers`
--

LOCK TABLES `user_answers` WRITE;
/*!40000 ALTER TABLE `user_answers` DISABLE KEYS */;
INSERT INTO `user_answers` VALUES (49,1,3,1,2,NULL,'2025-05-02 15:10:40'),(50,1,3,2,7,NULL,'2025-05-02 15:10:40'),(51,1,4,3,10,NULL,'2025-05-02 15:11:36'),(52,1,4,4,15,NULL,'2025-05-02 15:11:36'),(53,1,4,5,17,NULL,'2025-05-02 15:11:36'),(54,1,4,6,22,NULL,'2025-05-02 15:11:36'),(63,1,5,7,25,NULL,'2025-05-21 15:02:18'),(64,1,5,8,30,NULL,'2025-05-21 15:02:18');
/*!40000 ALTER TABLE `user_answers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-09 14:32:49