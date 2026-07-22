-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2026 at 12:50 PM
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
-- Table structure for table `chat_access`
--

CREATE TABLE `chat_access` (
  `id` int(11) NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_access`
--

INSERT INTO `chat_access` (`id`, `chat_room_id`, `user_id`, `is_deleted`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 1, 2, 0),
(4, 2, 3, 0),
(9, 1, 3, 0),
(10, 1, 5, 0),
(15, 5, 2, 0),
(16, 5, 6, 0),
(17, 6, 1, 0),
(18, 6, 5, 0),
(19, 7, 2, 0),
(20, 7, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `message`, `chat_room_id`, `created_at`) VALUES
(21, 1, 'This is Chat 2', 2, '2025-04-17 07:33:31'),
(22, 1, 'Test Chat in 2 box', 2, '2025-04-17 07:39:47'),
(23, 1, 'Chat box 2', 2, '2025-04-17 07:40:37'),
(37, 2, 'Hola', 5, '2025-04-28 09:27:25'),
(44, 1, 'Hi', 1, '2026-03-27 12:33:31'),
(45, 2, 'fgh', 1, '2026-03-27 12:38:25'),
(47, 2, 'Hello', 1, '2026-03-30 03:32:04'),
(48, 2, 'สวัสดีครับ', 1, '2026-03-30 03:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `name`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'Science 1/2568', '2025-04-17 02:30:01', '2025-05-24 01:56:32', 0),
(2, 'Bancha Siripapan Jet', '2025-04-17 02:30:01', '2025-06-05 04:49:13', 0),
(5, 'new_chat[26]', '2025-04-28 09:27:16', '2025-04-28 09:27:16', 0),
(6, 'Kanya Sukseree Queen', '2025-05-24 02:49:54', '2025-06-05 04:49:00', 0),
(7, 'Chat-Private', '2026-03-30 03:45:33', '2026-03-30 03:46:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `question_id`, `choice_text`, `is_correct`) VALUES
(1, 1, 'sqrt(6)', 0),
(2, 1, '2 + 2 - 2', 1),
(3, 1, '4 x 4 / 4', 0),
(4, 1, '6 - 2 + (-4 - 2)', 0),
(5, 2, '2 % 0', 0),
(6, 2, '1 + 1 = 2', 1),
(7, 2, '3 - 1', 0),
(8, 2, '5 - 3', 0),
(9, 3, '980', 0),
(10, 3, '1080', 1),
(11, 3, '1180', 0),
(12, 3, '1280', 0),
(13, 4, 'A = 2 B = 1 C = 3', 0),
(14, 4, 'B = 2 A = 3 C = 2', 0),
(15, 4, 'B = 2 C = 1 A = 3', 1),
(16, 4, 'A = 2 B = 1 C = 1', 0),
(17, 5, '7', 1),
(18, 5, '70', 0),
(19, 5, '700', 0),
(20, 5, 'Not choice is correct', 0),
(21, 6, 'together', 0),
(22, 6, 'Add', 1),
(23, 6, 'sum', 0),
(24, 6, 'all choice', 0),
(25, 7, 'ต้นไม้', 1),
(26, 7, 'สาม', 0),
(27, 7, 'พยัญชนะภาษาอังกฤษ', 0),
(28, 7, 'T', 0),
(29, 8, 'สอง', 0),
(30, 8, 'เช่นกัน', 1),
(31, 8, 'สวนสัตว์', 0),
(32, 8, 'เครื่องมือ', 0),
(33, 9, 'ระบบปฏิบัติการสำหรับเซิร์ฟเวอร์', 0),
(34, 9, 'ภาษาโปรแกรมที่ใช้งานง่ายและได้รับความนิยม', 1),
(35, 9, 'โปรแกรมตัดต่อวิดีโอ', 0),
(36, 9, 'เบราว์เซอร์สำหรับเขียนเว็บไซต์', 0),
(37, 10, '.html', 0),
(38, 10, '.js', 0),
(39, 10, '.py', 1),
(40, 10, '.png', 0),
(41, 11, 'า', 1),
(42, 11, 'ส', 0),
(43, 11, 'ง', 0),
(44, 12, 'เพื่อจัดทำรายงานประจำวันของคลังสินค้า', 0),
(45, 12, ' เพื่อนำไปใช้ในการวิเคราะห์และวางแผนการจัดการคลังสินค้า', 1),
(46, 12, ' เพื่อตรวจสอบความถูกต้องของสินค้าคงคลัง', 0),
(47, 12, ' เพื่อปรับปรุงระบบรักษาความปลอดภัยของคลังสินค้า', 0),
(48, 13, 'การรับ การจัดเก็บ และการเบิกจ่ายสินค้า', 0),
(49, 13, 'การบำรุงรักษาสิ่งอำนวยความสะดวกในคลังสินค้า', 0),
(50, 13, 'การจัดการบุคลากรในคลังสินค้า', 0),
(51, 13, 'ถูกทุกข้อ', 1),
(52, 14, 'ใช้ในการควบคุมอุณหภูมิและความชื้นในคลังสินค้า', 0),
(53, 14, 'ใช้ในการวางแผนทรัพยากรขององค์กรโดยรวม รวมถึงการจัดการคลังสินค้า', 1),
(54, 14, ' ใช้ในการติดตามตำแหน่งของสินค้าในคลังสินค้าแบบเรียลไทม์', 0),
(55, 14, ' ใช้ในการออกใบแจ้งหนี้และใบเสร็จรับเงิน', 0),
(56, 15, 'การจัดการความสัมพันธ์กับลูกค้า', 0),
(57, 15, ' การจัดการกระบวนการต่างๆ ภายในคลังสินค้า เช่น การรับ การจัดเก็บ และการเบิกจ่าย', 1),
(58, 15, ' การวางแผนการผลิต', 0),
(59, 15, 'การจัดการด้านการเงินและบัญชี', 0),
(60, 16, ' มีราคาถูกและติดตั้งง่าย', 0),
(61, 16, ' สามารถอ่านข้อมูลได้โดยไม่ต้องสัมผัสและอ่านข้อมูลได้หลายรายการพร้อมกัน', 1),
(62, 16, ' มีความแม่นยำสูงในการนับจำนวนสินค้า', 0),
(63, 16, ' ช่วยลดความจำเป็นในการใช้พนักงาน', 0),
(64, 17, ' ใช้ในการควบคุมอุณหภูมิของสินค้า', 0),
(65, 17, ' ใช้ในการป้องกันการโจรกรรมสินค้า', 0),
(66, 17, ' ใช้ในการระบุและติดตามสินค้าได้อย่างรวดเร็วและแม่นยำ', 1),
(67, 17, 'ใช้ในการสื่อสารกับลูกค้า', 0),
(68, 18, ' ระบบ ERP', 0),
(69, 18, 'ระบบ WMS', 0),
(70, 18, ' RFID และ GPS', 1),
(71, 18, 'Barcode Scanner', 0),
(72, 19, 'ลดต้นทุนการดำเนินงาน', 0),
(73, 19, ' เพิ่มความแม่นยำและความรวดเร็ว', 0),
(74, 19, 'ปรับปรุงประสิทธิภาพโดยรวม', 0),
(75, 19, ' ถูกทุกข้อ', 1),
(76, 20, ' งบประมาณที่มี', 0),
(77, 20, 'เทคโนโลยีที่มีอยู่ในปัจจุบัน', 0),
(78, 20, 'ความสามารถของบุคลากร', 0),
(79, 20, 'วัตถุประสงค์และความต้องการขององค์กร', 1),
(80, 21, ' อัตราการใช้ประโยชน์พื้นที่คลังสินค้า (Warehouse Space Utilization Rate)', 1),
(81, 21, 'รอบการหมุนเวียนสินค้า (Inventory Turnover)', 0),
(82, 21, 'ระยะเวลาในการเบิกจ่ายสินค้า (Order Fulfillment Cycle Time)', 0),
(83, 21, 'ระยะเวลานำ (Lead Time)', 0),
(84, 22, ' ความผิดพลาดจากการปฏิบัติงานของพนักงาน', 1),
(85, 22, 'ความผิดพลาดในการป้อนข้อมูล', 0),
(86, 22, 'ความผิดพลาดของระบบคอมพิวเตอร์', 0),
(87, 22, 'ความผิดพลาดของเครื่องจักร', 0),
(88, 23, ' Barcode', 0),
(89, 23, ' RFID', 0),
(90, 23, 'GPS Tracker', 1),
(91, 23, 'NFC (Near-Field Communication)', 0),
(92, 24, ' ช่วยลดความผิดพลาดในการทำงาน', 0),
(93, 24, 'เพิ่มประสิทธิภาพในการใช้เทคโนโลยี', 0),
(94, 24, 'ลดการต่อต้านการเปลี่ยนแปลง', 0),
(95, 24, 'ถูกทุกข้อ', 1),
(96, 25, 'การตลาดและการขาย', 0),
(97, 25, 'การผลิตและการจัดซื้อ', 0),
(98, 25, 'การรับ การจัดเก็บ และการเบิกจ่ายสินค้า', 1),
(99, 25, 'การจัดการด้านการเงินและบัญชี', 0),
(100, 26, ' บาร์โค้ด (Barcode)', 0),
(101, 26, 'อาร์เอฟไอดี (RFID)', 1),
(102, 26, ' รหัสคิวอาร์ (QR Code)', 0),
(103, 26, ' เอ็นเอฟซี (NFC)', 0),
(104, 27, ' การรับสินค้า', 0),
(105, 27, 'การจัดเก็บสินค้า', 0),
(106, 27, 'การหยิบสินค้า', 1),
(107, 27, 'การตรวจสอบสินค้า', 0),
(108, 28, 'จำนวนเทคโนโลยีที่นำมาใช้', 0),
(109, 28, 'ความพึงพอใจของพนักงานต่อเทคโนโลยี', 0),
(110, 28, ' ผลกระทบต่อประสิทธิภาพ ต้นทุน และความถูกต้องในการดำเนินงาน', 1),
(111, 28, 'ความทันสมัยของเทคโนโลยีที่ใช้', 0),
(112, 29, 'ระบบการจัดการเอกสาร', 0),
(113, 29, ' ระบบ ERP และ WMS ที่มีการเชื่อมโยงข้อมูลแบบเรียลไทม์', 1),
(114, 29, 'ระบบรักษาความปลอดภัยในคลังสินค้า', 0),
(115, 29, 'ระบบการจัดการการขนส่ง', 0),
(116, 30, ' ระบบบาร์โค้ด', 0),
(117, 30, ' ระบบ RFID', 0),
(118, 30, ' ระบบกล้องวงจรปิด', 1),
(119, 30, 'ระบบ ERP', 0),
(120, 31, 'ถูก', 1),
(121, 31, 'ผิด', 0);

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
(113, 35, 1, 'Python คืออะไร', '2026-03-31', '2026-03-31', 0),
(114, 35, 1, 'Python เป็นภาษาโปรแกรมมิ่ง (Programming Language) ที่ถูกออกแบบมาให้เขียนง่าย อ่านง่าย และเข้าใจได้รวดเร็ว เหมาะสำหรับทั้งผู้เริ่มต้นและนักพัฒนาระดับมืออาชีพ &lt;/br&gt; Python ถูกสร้างขึ้นโดย Guido van Rossum และเปิดตัวครั้งแรกในปี 1991 โดยมีแนวคิดหลักคือ “Code should be readable” &lt;/br&gt; 💡 Python ใช้ทำอะไรได้บ้าง &lt;/br&gt;🌐 พัฒนาเว็บไซต์ (Web Development) &lt;/br&gt;🤖 ปัญญาประดิษฐ์ (AI / Machine Learning) &lt;/br&gt;📊 วิเคราะห์ข้อมูล (Data Science) &lt;/br&gt;⚙️ Automation (เขียนสคริปต์อัตโนมัติ) &lt;/br&gt;🔌 IoT เช่น ESP32 / Raspberry Pi', '2026-03-31', '2026-03-31', 0),
(115, 35, 1, 'จุดเด่นของ Python', '2026-03-31', '2026-03-31', 0),
(116, 35, 1, '1. เขียนง่าย อ่านง่าย\nprint(\"Hello World\")\n\n2. ไม่ต้องกำหนดชนิดข้อมูล (Dynamic Typing)\nx = 10\nx = \"Hello\"\n\n3. มี Library เยอะมาก\nเช่น pandas, numpy, matplotlib, flask\nทำงานได้เร็วขึ้น ไม่ต้องเขียนเองทั้งหมด\n\n4. รองรับหลายแพลตฟอร์ม\nWindows / Linux / macOS\nเขียนครั้งเดียว รันได้หลายที่\n\n5. ใช้ได้หลายสายงาน\nPython ไม่ได้จำกัดแค่สายเดียว เช่น:\n\nWeb\nData\nAI\nNetwork / Automation', '2026-03-31', '2026-03-31', 0),
(117, 36, 1, 'รูปภาพ', '2026-05-21', '2026-05-21', 0),
(118, 36, 2, '../uploads/admin/Screenshot 2026-05-19 093334.png', '2026-05-21', '2026-05-21', 0),
(119, 36, 2, '../temp/admin/Screenshot 2026-05-19 093334.png', '2026-05-21', '2026-05-21', 1),
(120, 36, 1, 'รูปภาพ', '2026-05-21', '2026-05-21', 1),
(121, 36, 2, '../temp/admin/Screenshot 2026-05-19 093334.png', '2026-05-21', '2026-05-21', 1),
(122, 36, 2, '../temp/admin/Screenshot 2026-05-19 093334.png', '2026-05-21', '2026-05-21', 1),
(123, 36, 1, 'วิดีโอ', '2026-05-21', '2026-05-21', 0),
(124, 36, 3, '../uploads/admin/2024-12-09 15-57-56.mkv', '2026-05-21', '2026-05-21', 0),
(125, 36, 3, '../temp/admin/2024-12-09 15-57-56.mkv', '2026-05-21', '2026-05-21', 1),
(126, 36, 1, 'pdf', '2026-05-21', '2026-05-21', 0),
(127, 36, 4, '../uploads/admin/ชุดปฏิบัติการเกษตรอัจฉริยะ พร้อมโรงเรือน.pdf', '2026-05-21', '2026-05-21', 0),
(128, 36, 4, '../temp/admin/ชุดปฏิบัติการเกษตรอัจฉริยะ พร้อมโรงเรือน.pdf', '2026-05-21', '2026-05-21', 1),
(129, 36, 1, '3D', '2026-05-21', '2026-05-21', 0),
(130, 36, 6, '../uploads/admin/Spanner.glb', '2026-05-21', '2026-05-21', 0),
(131, 36, 6, '../temp/admin/Spanner.glb', '2026-05-21', '2026-05-21', 1),
(132, 36, 1, 'ข้อสอบ', '2026-05-21', '2026-05-21', 0),
(133, 36, 7, '6_python Test', '2026-05-21', '2026-05-21', 0),
(134, 37, 1, 'Screenshot 2026-07-22 115617.png', '2026-07-19', '2026-07-19', 0),
(135, 37, 7, '4_post Math', '2026-07-19', '2026-07-19', 1),
(136, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115617.png', '2026-07-22', '2026-07-22', 0),
(137, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115645.png', '2026-07-22', '2026-07-22', 0),
(138, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115655.png', '2026-07-22', '2026-07-22', 0),
(139, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115716.png', '2026-07-22', '2026-07-22', 0),
(140, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115736.png', '2026-07-22', '2026-07-22', 0),
(141, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115749.png', '2026-07-22', '2026-07-22', 0),
(142, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115810.png', '2026-07-22', '2026-07-22', 0),
(143, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115836.png', '2026-07-22', '2026-07-22', 0),
(144, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115851.png', '2026-07-22', '2026-07-22', 0),
(145, 37, 2, '../uploads/admin/Screenshot 2026-07-22 115911.png', '2026-07-22', '2026-07-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `image_code` varchar(100) NOT NULL,
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
(1, '100100', '6.png', 'Python Programming for Beginners', 'หลักสูตรนี้ออกแบบสำหรับผู้เริ่มต้นที่ไม่มีพื้นฐานการเขียนโปรแกรม โดยจะพาผู้เรียนเรียนรู้ภาษา Python ตั้งแต่พื้นฐานไปจนถึงสามารถนำไปประยุกต์ใช้งานจริงได้ เช่น การจัดการข้อมูล การเขียนโปรแกรมอัตโนมัติ และการสร้างโปรเจกต์ขนาดเล็ก\r\n\r\nเนื้อหาครอบคลุมตั้งแต่ Syntax เบื้องต้น โครงสร้างควบคุม (Control Flow) ฟังก์ชัน (Functions) ไปจนถึงการจัดการไฟล์และการใช้งาน Library ต่าง ๆ เพื่อให้ผู้เรียนสามารถพัฒนาทักษะและต่อยอดไปยังสายงาน IT ได้', 'เมื่อเรียนจบหลักสูตรนี้ ผู้เรียนจะสามารถ:\r\n\r\nเข้าใจพื้นฐานของภาษา Python และหลักการเขียนโปรแกรม\r\nเขียนโปรแกรมเบื้องต้นได้อย่างถูกต้อง\r\nใช้เงื่อนไขและลูปเพื่อควบคุมการทำงานของโปรแกรม\r\nสร้างและใช้งานฟังก์ชันได้\r\nจัดการข้อมูลด้วย List, Dictionary และ Data Structure ต่าง ๆ\r\nอ่าน/เขียนไฟล์ และจัดการข้อมูลเบื้องต้น\r\nพัฒนาโปรเจกต์ Python ขนาดเล็กได้', 0, 1, '2026-03-31', '2026-03-31', 1, 1, 1, 0),
(14, '122000', 'Screenshot 2026-07-22 115316.png', 'A8', 'คำอธิบายคอร์สเรียน เพื่อให้ผู้เรียนได้เข้าในภาพรวม', 'วัตถุประสงค์หลักของระบบงานอัตโนมัติเพิ่มประสิทธิภาพ: เร่งความเร็วการทำงานและเพิ่มผลผลิตลดความผิดพลาด: ป้องกันข้อผิดพลาดจากการทำงานด้วยมือของคนประหยัดต้นทุน: ลดเวลาและค่าใช้จ่ายในระยะยาว', 0, 1, '2026-07-19', '2026-07-19', 1, 1, 1, 0);

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
(1, 1, 1, 0, '2026-03-31', 0, 0),
(10, 14, 1, 0, '2026-07-19', 0, 0),
(11, 14, 2, 0, '2026-07-19', 0, 0),
(12, 14, 3, 0, '2026-07-19', 0, 0),
(13, 14, 5, 0, '2026-07-19', 0, 0),
(14, 14, 6, 0, '2026-07-19', 0, 0),
(18, 1, 3, 0, '2026-07-22', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_points`
--

CREATE TABLE `course_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `point` float NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_points`
--

INSERT INTO `course_points` (`id`, `user_id`, `course_id`, `unit_id`, `exam_id`, `point`, `total`) VALUES
(1, 1, 14, 37, 4, 0, 0);

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
(1, 14, 1, '08:00', '12:00', 0),
(2, 14, 4, '13:00', '15:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `update_date` date NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_student`
--

INSERT INTO `course_student` (`id`, `course_id`, `owner_id`, `create_date`, `update_date`, `is_active`, `is_deleted`) VALUES
(1, 14, 1, '2026-07-19', '2026-07-19', 0, 0);

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
(1, 'monday', 'Mon', 0),
(2, 'tuesday', 'Tue', 0),
(3, 'wednesday', 'Wed', 0),
(4, 'thursday', 'Thu', 0),
(5, 'friday', 'Fri', 0),
(6, 'saturday', 'Sat', 0),
(7, 'sunday', 'Sun', 0);

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
(2, 2, 'Computer Science', 0),
(3, 2, 'Mathematics', 0);

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
(0, 'please select', 0),
(1, 'all faculty', 0),
(2, 'science', 0),
(4, 'engineering', 0);

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
  `youtube_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_profile`
--

INSERT INTO `home_profile` (`id`, `slide01`, `slide02`, `slide03`, `icon01`, `icon02`, `icon03`, `icon04`, `icon05`, `icon06`, `icon07`, `icon08`, `youtube_id`) VALUES
(1, 'e-learning-graphics-on-laptop-3obdlxn0d9fhvvfd.jpg', 'library-books-for-learning-26sseqbz63dl9gfj.jpg', 'stack-of-books-for-learning-lmttni7zhot3rfoa.jpg', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'icon_512x512.png', 'eukKvcwJpMA');

-- --------------------------------------------------------

--
-- Table structure for table `log_action`
--

CREATE TABLE `log_action` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `username` varchar(255) DEFAULT 'guest',
  `ip_address` varchar(45) DEFAULT 'unknown',
  `user_agent` text DEFAULT 'unknown',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_action`
--

INSERT INTO `log_action` (`id`, `category`, `message`, `username`, `ip_address`, `user_agent`, `created_at`) VALUES
(5, 'general', 'Create examination Failed: Column count doesn\'t match value count at row 1', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-07 10:39:23'),
(6, 'general', 'Create examination success.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-07 10:40:50'),
(7, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 08:38:42'),
(8, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 08:40:17'),
(9, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 09:08:42'),
(10, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 01:50:35'),
(11, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 04:24:16'),
(12, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 04:57:00'),
(13, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-18 04:04:46'),
(14, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-18 06:20:41'),
(15, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-18 07:51:31'),
(16, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-19 02:31:51'),
(17, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 02:39:29'),
(18, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 03:31:32'),
(19, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 04:09:50'),
(20, 'general', '[user] Login successful.', 'user', '192.168.1.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 09:24:21'),
(21, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 09:37:47'),
(22, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 10:08:35'),
(23, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 10:08:41'),
(24, 'general', '[user] Login successful.', 'user', '49.237.40.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-20 20:56:02'),
(25, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 18:28:01'),
(26, 'general', '[user] Login successful.', 'user', '49.237.6.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 18:43:51'),
(27, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 08:06:05'),
(28, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 08:10:17'),
(29, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 08:13:48'),
(30, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 08:43:53'),
(31, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 02:31:41'),
(32, 'general', '[admin] Login successful.', 'admin', '100.125.232.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-24 10:17:07'),
(33, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-25 04:11:54'),
(34, 'general', '[Bancha.S.Admin] Login successful.', 'Bancha.S.Admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 04:12:48'),
(35, 'general', '[Kanya.S.Admin] Login successful.', 'Kanya.S.Admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-25 04:13:25'),
(36, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-28 02:40:07'),
(37, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-28 09:14:57'),
(38, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 01:59:50'),
(39, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 01:42:38'),
(40, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 03:27:36'),
(41, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 06:55:28'),
(42, 'general', 'Create examination success.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 07:04:35'),
(43, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 07:55:40'),
(44, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 07:56:18'),
(45, 'general', 'Create examination success.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 08:02:15'),
(46, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 08:11:49'),
(47, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 08:27:19'),
(48, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 10:02:28'),
(49, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 10:10:38'),
(50, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-03 01:44:07'),
(51, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-03 01:46:15'),
(52, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 06:45:34'),
(53, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 06:49:57'),
(54, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 08:27:27'),
(55, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 08:28:05'),
(56, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 08:28:37'),
(57, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 08:29:29'),
(58, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 08:52:00'),
(59, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 09:34:20'),
(60, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 10:13:20'),
(61, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 03:14:39'),
(62, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 09:26:22'),
(63, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 09:32:21'),
(64, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 09:33:42'),
(65, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 09:38:07'),
(66, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:01:32'),
(67, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:04:53'),
(68, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:06:58'),
(69, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:15:56'),
(70, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:23:06'),
(71, 'general', 'userAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 01:41:19'),
(72, 'general', 'userAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 01:41:26'),
(73, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 01:41:32'),
(74, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 02:03:46'),
(75, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 04:47:42'),
(76, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 08:28:32'),
(77, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 09:55:24'),
(78, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 02:35:12'),
(79, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 07:54:37'),
(80, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 04:15:40'),
(81, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 04:15:56'),
(82, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-24 01:49:38'),
(83, 'general', 'Create examination success.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-24 07:58:44'),
(84, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 02:57:52'),
(85, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 06:10:07'),
(86, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 08:07:26'),
(87, 'general', '[user] Login successful.', 'user', '49.230.181.53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 08:21:08'),
(88, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:05:33'),
(89, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 07:18:20'),
(90, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 07:18:46'),
(91, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:21:27'),
(92, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:21:27'),
(93, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:22:24'),
(94, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:22:24'),
(95, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-05 03:51:50'),
(96, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-05 03:51:50'),
(97, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-09 07:32:31'),
(98, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-09 07:32:31'),
(99, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-13 14:04:30'),
(100, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-13 14:04:30'),
(101, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 02:12:50'),
(102, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 02:12:50'),
(103, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 09:47:14'),
(104, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 09:47:14'),
(105, 'general', '[admin] Login successful.', 'admin', '58.10.107.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 10:15:13'),
(106, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '58.10.107.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 10:15:13'),
(107, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 02:27:16'),
(108, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 02:27:16'),
(109, 'general', '[admin] Login successful.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 02:28:23'),
(110, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 02:28:23'),
(111, 'general', '[admin] Login successful.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Mobile Safari/537.36', '2025-07-31 02:56:13'),
(112, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Mobile Safari/537.36', '2025-07-31 02:56:13'),
(113, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:27:32'),
(114, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:27:32'),
(115, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:28:37'),
(116, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:28:37'),
(117, 'general', '[user] Login successful.', 'user', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:33:21'),
(118, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:33:21'),
(119, 'general', '[admin] Login successful.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:39:15'),
(120, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:39:15'),
(121, 'general', '[admin] Login successful.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 06:16:48'),
(122, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 06:16:48'),
(123, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:35:29'),
(124, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:35:29'),
(125, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:44:28'),
(126, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:44:28'),
(127, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:20:05'),
(128, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:20:05'),
(129, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:51:12'),
(130, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:51:12'),
(131, 'general', '[admin] Login successful.', 'admin', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:33:23'),
(132, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:33:23'),
(133, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:34:52'),
(134, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:34:52'),
(135, 'general', '[admin] Login successful.', 'admin', '192.168.1.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:35:19'),
(136, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:35:19'),
(137, 'general', '[user] Login successful.', 'user', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:39:22'),
(138, 'general', 'userAn unknown user attempted to access the account.', 'user', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:39:22'),
(139, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 06:30:49'),
(140, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 06:30:49'),
(141, 'general', '[admin] Login successful.', 'admin', '58.10.135.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-21 16:06:30'),
(142, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '58.10.135.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-21 16:06:30'),
(143, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-23 04:17:10'),
(144, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-23 04:17:10'),
(145, 'general', '[admin] Login successful.', 'admin', '49.237.169.115', 'Mozilla/5.0 (Linux; Android 15; SM-A556E Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.52 Mobile Safari/537.36 Line/15.15.1/IAB', '2025-09-24 00:13:15'),
(146, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.169.115', 'Mozilla/5.0 (Linux; Android 15; SM-A556E Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.52 Mobile Safari/537.36 Line/15.15.1/IAB', '2025-09-24 00:13:15'),
(147, 'general', '[admin] Login successful.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 03:59:47'),
(148, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 03:59:47'),
(149, 'general', '[admin] Login successful.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 04:41:05'),
(150, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 04:41:06'),
(151, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 03:01:53'),
(152, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 03:01:53'),
(153, 'general', '[user] Login successful.', 'user', '27.145.145.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:44:58'),
(154, 'general', 'userAn unknown user attempted to access the account.', 'user', '27.145.145.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:44:58'),
(155, 'general', 'Create examination success.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 04:04:07'),
(156, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 08:16:39'),
(157, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 08:17:08'),
(158, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 08:17:09'),
(159, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-10-14 08:19:36'),
(160, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-10-14 08:19:36'),
(161, 'general', '[admin] Login successful.', 'admin', '182.232.45.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-15 10:26:31'),
(162, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.45.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-15 10:26:31'),
(163, 'general', '[admin] Login successful.', 'admin', '182.232.39.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 03:20:23'),
(164, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.39.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 03:20:23'),
(165, 'general', '[admin] Login successful.', 'admin', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 15:16:06'),
(166, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 15:16:06'),
(167, 'general', 'Create examination success.', 'guest', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 15:55:37'),
(168, 'general', '[admin] Login successful.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 03:50:58'),
(169, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 03:50:58'),
(170, 'general', '[admin] Login successful.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 05:39:39'),
(171, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 05:39:40'),
(172, 'general', '[admin] Login successful.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 06:18:00'),
(173, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 06:18:00'),
(174, 'general', '[user] Login successful.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:04'),
(175, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:04'),
(176, 'general', '[user] Login successful.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:05'),
(177, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:05'),
(178, 'general', '[user] Login successful.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:07'),
(179, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:07'),
(180, 'general', '[user] Login successful.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:08'),
(181, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:08'),
(182, 'general', '[admin] Login successful.', 'admin', '182.232.42.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 14:16:46'),
(183, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.42.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 14:16:47'),
(184, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:14:44'),
(185, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:17:44'),
(186, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:18:30'),
(187, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:19:02'),
(188, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:19:58'),
(189, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:20:52'),
(190, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:22:00'),
(191, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:23:37'),
(192, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 02:15:03'),
(193, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 02:15:03'),
(194, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:31:17'),
(195, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:31:17'),
(196, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 11:07:19'),
(197, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 11:07:19'),
(198, 'general', '[admin] Login successful.', 'admin', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:19:31'),
(199, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:19:31'),
(200, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:25:40'),
(201, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:25:40'),
(202, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:41'),
(203, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:41'),
(204, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:43'),
(205, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:43'),
(206, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:44'),
(207, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:44'),
(208, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:46'),
(209, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:46'),
(210, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:47'),
(211, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:47'),
(212, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(213, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(214, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(215, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(216, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:33:16'),
(217, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:33:16'),
(218, 'general', '[user] Login successful.', 'user', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:38:00'),
(219, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:38:00'),
(220, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:47'),
(221, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:47'),
(222, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:50'),
(223, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:50'),
(224, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:56:26'),
(225, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:56:26'),
(226, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:01:38'),
(227, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:01:38'),
(228, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:18:19'),
(229, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:18:19');
INSERT INTO `log_action` (`id`, `category`, `message`, `username`, `ip_address`, `user_agent`, `created_at`) VALUES
(230, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:35:29'),
(231, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:35:29'),
(232, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:42:07'),
(233, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:42:07'),
(234, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 03:58:53'),
(235, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 03:58:53'),
(236, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:00:51'),
(237, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:00:51'),
(238, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:01:09'),
(239, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:01:09'),
(240, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 05:29:26'),
(241, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 05:29:27'),
(242, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 05:58:55'),
(243, 'general', '[admin] Login successful.', 'admin', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 05:59:13'),
(244, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 05:59:13'),
(245, 'general', '[user] Login successful.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-28 06:06:25'),
(246, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-28 06:06:25'),
(247, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 06:06:42'),
(248, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 06:06:53'),
(249, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 06:06:53'),
(250, 'general', '[user] Login successful.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', '2026-03-28 06:10:02'),
(251, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', '2026-03-28 06:10:02'),
(252, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:01'),
(253, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:17'),
(254, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:47'),
(255, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:02:04'),
(256, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:03:16'),
(257, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:03:16'),
(258, 'general', '[admin] Login successful.', 'admin', '49.229.218.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 13:37:12'),
(259, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.218.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 13:37:12'),
(260, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 01:49:34'),
(261, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 01:49:34'),
(262, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:08'),
(263, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:08'),
(264, 'general', 'EarthAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:21'),
(265, 'general', 'EarthAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:33'),
(266, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:39'),
(267, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:39'),
(268, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-30 02:20:46'),
(269, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-30 02:20:46'),
(270, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:20:50'),
(271, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:20:50'),
(272, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:38:28'),
(273, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:38:28'),
(274, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:25:24'),
(275, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:25:24'),
(276, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:26:58'),
(277, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:26:58'),
(278, 'general', '[user] Login successful.', 'user', '49.237.107.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 03:28:41'),
(279, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.107.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 03:28:41'),
(280, 'general', 'UserAn unknown user attempted to access the account.', 'guest', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:30:38'),
(281, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:31:33'),
(282, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:31:33'),
(283, 'general', '[user] Login successful.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:57'),
(284, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:57'),
(285, 'general', '[user] Login successful.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:59'),
(286, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:59'),
(287, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 06:19:30'),
(288, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 06:19:30'),
(289, 'general', '[admin] Login successful.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:29'),
(290, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:29'),
(291, 'general', '[admin] Login successful.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:31'),
(292, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:31'),
(293, 'general', '[user] Login successful.', 'user', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:09:16'),
(294, 'general', 'userAn unknown user attempted to access the account.', 'user', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:09:16'),
(295, 'general', '[user] Login successful.', 'user', '49.0.69.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-31 02:21:43'),
(296, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-31 02:21:43'),
(297, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 02:40:37'),
(298, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 02:40:37'),
(299, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 05:54:58'),
(300, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 05:54:58'),
(301, 'general', '[user] Login successful.', 'user', '27.145.110.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-04-01 10:17:34'),
(302, 'general', 'userAn unknown user attempted to access the account.', 'user', '27.145.110.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-04-01 10:17:34'),
(303, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 03:15:09'),
(304, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 03:15:20'),
(305, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 03:15:20'),
(306, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:40'),
(307, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:41'),
(308, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:43'),
(309, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:01'),
(310, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:03'),
(311, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:05'),
(312, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:25'),
(313, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 07:30:32'),
(314, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 07:30:40'),
(315, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 07:30:40'),
(316, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:22:58'),
(317, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:22:58'),
(318, 'general', '[admin] Login successful.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:08:38'),
(319, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:08:38'),
(320, 'general', '[admin] Login successful.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:25'),
(321, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:25'),
(322, 'general', '[admin] Login successful.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:39'),
(323, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:39'),
(324, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 09:29:44'),
(325, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 09:29:44'),
(326, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-06 02:49:09'),
(327, 'general', '[admin] Login successful.', 'admin', '27.145.145.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-07 02:58:17'),
(328, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.145.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-07 02:58:17'),
(329, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-07 02:59:06'),
(330, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-07 02:59:06'),
(331, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:08:14'),
(332, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:08:14'),
(333, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:30:03'),
(334, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:30:03'),
(335, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 04:51:11'),
(336, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 04:51:19'),
(337, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 04:51:19'),
(338, 'general', '[admin] Login successful.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:19:32'),
(339, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:19:32'),
(340, 'general', '[user] Login successful.', 'user', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:42:52'),
(341, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:42:52'),
(342, 'general', '[admin] Login successful.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:43:17'),
(343, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:43:17'),
(344, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 02:22:19'),
(345, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 02:22:19'),
(346, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-20 07:29:14'),
(347, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-20 07:29:14'),
(348, 'general', '[admin] Login successful.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 02:44:35'),
(349, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 02:44:35'),
(350, 'general', '[user] Login successful.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:23:05'),
(351, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:23:05'),
(352, 'general', 'banchaAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:50:17'),
(353, 'general', '[Admin02] Login successful.', 'Admin02', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:50:30'),
(354, 'general', 'Admin02An unknown user attempted to access the account.', 'Admin02', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:50:30'),
(355, 'general', '[admin] Login successful.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:51:17'),
(356, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `log_error`
--

CREATE TABLE `log_error` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `username` varchar(255) DEFAULT 'guest',
  `ip_address` varchar(45) DEFAULT 'unknown',
  `user_agent` text DEFAULT 'unknown',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_error`
--

INSERT INTO `log_error` (`id`, `category`, `message`, `username`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'export', 'การ export database ล้มเหลว (code: 1)', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 07:42:02'),
(2, 'export', 'การ export database ล้มเหลว (code: 1)', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 07:43:17'),
(3, 'export', 'การ export database ล้มเหลว (code: 1)', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 07:43:44'),
(4, 'export', 'การ export database ล้มเหลว (code: 1)', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 08:43:17'),
(5, 'general', 'Column count doesn\'t match value count at row 1', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-07 10:39:23'),
(6, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 10:08:35'),
(7, 'general', 'userAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 01:41:19'),
(8, 'general', 'userAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 01:41:26'),
(9, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 07:18:21'),
(10, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 07:18:46'),
(11, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:21:27'),
(12, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 07:22:24'),
(13, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-05 03:51:50'),
(14, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-09 07:32:31'),
(15, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-13 14:04:30'),
(16, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 02:12:50'),
(17, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 09:47:14'),
(18, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '58.10.107.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 10:15:13'),
(19, 'export', 'ไม่พบ mysqldump ที่ path: C:/xampp/mysql/bin/mysqldump.exe', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 10:59:09'),
(20, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 02:27:16'),
(21, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 02:28:23'),
(22, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Mobile Safari/537.36', '2025-07-31 02:56:13'),
(23, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:27:32'),
(24, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 03:28:37'),
(25, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:33:21'),
(26, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 03:39:15'),
(27, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 06:16:48'),
(28, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:35:29'),
(29, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:44:28'),
(30, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:20:05'),
(31, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 02:51:12'),
(32, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:33:23'),
(33, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:34:52'),
(34, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 04:35:19'),
(35, 'general', 'userAn unknown user attempted to access the account.', 'user', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 04:39:22'),
(36, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 06:30:49'),
(37, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '58.10.135.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-21 16:06:30'),
(38, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-23 04:17:10'),
(39, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.169.115', 'Mozilla/5.0 (Linux; Android 15; SM-A556E Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.52 Mobile Safari/537.36 Line/15.15.1/IAB', '2025-09-24 00:13:15'),
(40, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 03:59:47'),
(41, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 04:41:06'),
(42, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 03:01:53'),
(43, 'general', 'userAn unknown user attempted to access the account.', 'user', '27.145.145.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 03:44:58'),
(44, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 08:16:39'),
(45, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 08:17:09'),
(46, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-10-14 08:19:36'),
(47, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.45.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-15 10:26:31'),
(48, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.39.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 03:20:23'),
(49, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 15:16:06'),
(50, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 03:50:58'),
(51, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 05:39:40'),
(52, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 06:18:00'),
(53, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:04'),
(54, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:05'),
(55, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:07'),
(56, 'general', 'userAn unknown user attempted to access the account.', 'user', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 06:25:08'),
(57, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '182.232.42.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 14:16:47'),
(58, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:14:44'),
(59, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:17:44'),
(60, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:18:30'),
(61, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:19:02'),
(62, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:19:58'),
(63, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:20:52'),
(64, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:22:00'),
(65, 'general', 'smartict@gmail.comAn unknown user attempted to access the account.', 'guest', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 09:23:37'),
(66, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 02:15:03'),
(67, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 09:31:17'),
(68, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 11:07:19'),
(69, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:19:31'),
(70, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:25:40'),
(71, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:41'),
(72, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:43'),
(73, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:44'),
(74, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:46'),
(75, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:47'),
(76, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(77, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:31:50'),
(78, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 12:33:16'),
(79, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:38:00'),
(80, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:47'),
(81, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 12:46:50'),
(82, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 12:56:26'),
(83, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:01:38'),
(84, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:18:19'),
(85, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:35:29'),
(86, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 02:42:07'),
(87, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 03:58:53'),
(88, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:00:51'),
(89, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 04:01:09'),
(90, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 05:29:27'),
(91, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 05:58:55'),
(92, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 05:59:13'),
(93, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-28 06:06:25'),
(94, 'general', 'adminAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 06:06:42'),
(95, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 06:06:53'),
(96, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', '2026-03-28 06:10:02'),
(97, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:01'),
(98, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:17'),
(99, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:01:47'),
(100, 'general', 'ST01An unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:02:04'),
(101, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 07:03:16'),
(102, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.218.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 13:37:12'),
(103, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 01:49:34'),
(104, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:08'),
(105, 'general', 'EarthAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:21'),
(106, 'general', 'EarthAn unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:33'),
(107, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:10:39'),
(108, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-30 02:20:46'),
(109, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:20:50'),
(110, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 02:38:28'),
(111, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:25:24'),
(112, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:26:58'),
(113, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.107.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 03:28:41'),
(114, 'general', 'UserAn unknown user attempted to access the account.', 'guest', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:30:38'),
(115, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 03:31:33'),
(116, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:57'),
(117, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 03:31:59'),
(118, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 06:19:30'),
(119, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:29'),
(120, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 07:23:31'),
(121, 'general', 'userAn unknown user attempted to access the account.', 'user', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:09:16'),
(122, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.0.69.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-31 02:21:43'),
(123, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 02:40:37'),
(124, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 05:54:58'),
(125, 'general', 'userAn unknown user attempted to access the account.', 'user', '27.145.110.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-04-01 10:17:34'),
(126, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 03:15:09'),
(127, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 03:15:20'),
(128, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:40'),
(129, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:41'),
(130, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:48:43'),
(131, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:01'),
(132, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:03'),
(133, 'general', 'superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:05'),
(134, 'general', 'Superadmin01An unknown user attempted to access the account.', 'guest', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 09:49:25'),
(135, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 07:30:32'),
(136, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 07:30:40'),
(137, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:22:58'),
(138, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:08:38'),
(139, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:25'),
(140, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 09:09:39'),
(141, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 09:29:44'),
(142, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-06 02:49:09'),
(143, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '27.145.145.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-07 02:58:17'),
(144, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-07 02:59:06'),
(145, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:08:14'),
(146, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 07:30:03'),
(147, 'general', 'superadmin01An unknown user attempted to access the account.', 'superadmin03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 04:51:11'),
(148, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 04:51:19'),
(149, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:19:32'),
(150, 'general', 'userAn unknown user attempted to access the account.', 'user', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:42:52'),
(151, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:43:17'),
(152, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 02:22:19'),
(153, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-20 07:29:14'),
(154, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 02:44:35'),
(155, 'general', 'userAn unknown user attempted to access the account.', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:23:05'),
(156, 'general', 'banchaAn unknown user attempted to access the account.', 'guest', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:50:17'),
(157, 'general', 'Admin02An unknown user attempted to access the account.', 'Admin02', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:50:30'),
(158, 'general', 'adminAn unknown user attempted to access the account.', 'admin', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 04:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `log_login`
--

CREATE TABLE `log_login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `action` enum('login','logout','login_failed') DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `log_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_login`
--

INSERT INTO `log_login` (`id`, `user_id`, `username`, `action`, `ip_address`, `user_agent`, `log_time`) VALUES
(1, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-04 15:34:59'),
(2, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-04 15:40:39'),
(3, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-04 15:40:51'),
(4, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-04 15:40:58'),
(5, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 10:53:53'),
(6, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 10:53:59'),
(7, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 10:55:05'),
(8, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 15:26:40'),
(9, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 15:38:42'),
(10, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 15:40:07'),
(11, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 15:40:17'),
(12, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 16:08:42'),
(13, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 08:50:35'),
(14, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 11:24:16'),
(15, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 11:57:00'),
(16, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-18 11:04:46'),
(17, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-18 13:20:41'),
(18, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-18 14:51:31'),
(19, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-19 09:31:51'),
(20, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 09:39:29'),
(21, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 10:31:32'),
(22, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 11:09:50'),
(23, 2, 'user', 'login', '192.168.1.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 16:24:21'),
(24, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 16:37:47'),
(25, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 17:08:35'),
(26, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 17:08:41'),
(27, 2, 'user', 'login', '49.237.40.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 03:56:02'),
(28, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-22 01:28:01'),
(29, 2, 'user', 'login', '49.237.6.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-22 01:43:51'),
(30, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 15:06:05'),
(31, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 15:10:17'),
(32, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 15:13:48'),
(33, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 15:43:53'),
(34, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 09:31:41'),
(35, 1, 'admin', 'login', '100.125.232.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-24 17:17:07'),
(36, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-25 11:11:54'),
(37, 3, 'Bancha.S.Admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 11:12:48'),
(38, 5, 'Kanya.S.Admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', '2025-04-25 11:13:25'),
(39, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-28 09:40:07'),
(40, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', '2025-04-28 16:14:48'),
(41, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-28 16:14:57'),
(42, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 08:59:46'),
(43, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 08:59:50'),
(44, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 08:42:38'),
(45, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 10:27:32'),
(46, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 10:27:36'),
(47, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 13:55:24'),
(48, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 13:55:28'),
(49, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 14:55:33'),
(50, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 14:55:40'),
(51, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 14:56:13'),
(52, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 14:56:18'),
(53, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 15:11:46'),
(54, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 15:11:49'),
(55, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 15:27:15'),
(56, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 15:27:19'),
(57, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 16:50:13'),
(58, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 17:02:28'),
(59, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 17:02:37'),
(60, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 17:10:38'),
(61, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-03 08:44:07'),
(62, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-03 08:46:08'),
(63, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-03 08:46:15'),
(64, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 13:45:34'),
(65, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 13:45:44'),
(66, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 13:49:57'),
(67, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:07:22'),
(68, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:27:27'),
(69, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:28:05'),
(70, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:28:33'),
(71, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:28:37'),
(72, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:28:41'),
(73, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:29:29'),
(74, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:51:56'),
(75, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:52:00'),
(76, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 16:34:12'),
(77, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 16:34:20'),
(78, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 17:13:17'),
(79, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 17:13:20'),
(80, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 10:14:39'),
(81, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:26:15'),
(82, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:26:22'),
(83, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:32:21'),
(84, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:33:33'),
(85, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:33:42'),
(86, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:38:07'),
(87, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 17:01:32'),
(88, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 17:04:53'),
(89, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 17:06:58'),
(90, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 17:15:56'),
(91, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 17:23:06'),
(92, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 08:41:19'),
(93, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 08:41:26'),
(94, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 08:41:32'),
(95, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 09:03:46'),
(96, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 11:46:21'),
(97, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 11:47:42'),
(98, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 15:21:35'),
(99, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 15:28:32'),
(100, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 16:25:03'),
(101, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 16:55:24'),
(102, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 09:35:12'),
(103, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 14:27:30'),
(104, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 14:54:37'),
(105, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 11:15:36'),
(106, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 11:15:40'),
(107, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 11:15:50'),
(108, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-23 11:15:56'),
(109, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-24 08:49:38'),
(110, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 09:57:52'),
(111, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 13:10:07'),
(112, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 15:07:26'),
(113, 2, 'user', 'login', '49.230.181.53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-03 15:21:08'),
(114, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 12:54:32'),
(115, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:05:33'),
(116, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 14:11:32'),
(117, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 14:18:20'),
(118, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-04 14:18:46'),
(119, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:21:27'),
(120, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:21:27'),
(121, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:21:54'),
(122, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:22:24'),
(123, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', '2025-06-04 14:22:24'),
(124, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-05 10:51:50'),
(125, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-05 10:51:50'),
(126, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-09 14:32:31'),
(127, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-09 14:32:31'),
(128, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-13 21:04:30'),
(129, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-13 21:04:30'),
(130, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 09:12:50'),
(131, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 09:12:50'),
(132, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 16:47:14'),
(133, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', '2025-06-14 16:47:14'),
(134, 1, 'admin', 'login', '58.10.107.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 17:15:13'),
(135, 0, 'admin', 'login_failed', '58.10.107.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-14 17:15:13'),
(136, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 09:27:16'),
(137, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 09:27:16'),
(138, 1, 'admin', 'login', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 09:28:23'),
(139, 0, 'admin', 'login_failed', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 09:28:23'),
(140, 1, 'admin', 'login', '49.230.59.171', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Mobile Safari/537.36', '2025-07-31 09:56:13'),
(141, 0, 'admin', 'login_failed', '49.230.59.171', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Mobile Safari/537.36', '2025-07-31 09:56:13'),
(142, 1, 'admin', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:27:20'),
(143, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:27:32'),
(144, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:27:32'),
(145, 2, 'user', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:28:26'),
(146, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:28:37'),
(147, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-31 10:28:37'),
(148, 1, 'admin', 'logout', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:33:13'),
(149, 2, 'user', 'login', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:33:21'),
(150, 0, 'user', 'login_failed', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:33:21'),
(151, 2, 'user', 'logout', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:38:57'),
(152, 1, 'admin', 'login', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:39:15'),
(153, 0, 'admin', 'login_failed', '49.230.59.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-31 10:39:15'),
(154, 1, 'admin', 'login', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 13:16:48'),
(155, 0, 'admin', 'login_failed', '27.145.152.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-31 13:16:48'),
(156, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 15:35:29'),
(157, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 15:35:29'),
(158, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 15:44:28'),
(159, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 15:44:28'),
(160, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 09:20:05'),
(161, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 09:20:05'),
(162, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 09:51:12'),
(163, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 09:51:12'),
(164, 1, 'admin', 'login', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 11:33:23'),
(165, 0, 'admin', 'login_failed', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 11:33:23'),
(166, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:34:52'),
(167, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:34:52'),
(168, 1, 'admin', 'login', '192.168.1.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:35:19'),
(169, 0, 'admin', 'login_failed', '192.168.1.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:35:19'),
(170, 2, 'user', 'login', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 11:39:22'),
(171, 0, 'user', 'login_failed', '110.168.235.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 11:39:22'),
(172, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 13:30:49'),
(173, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 13:30:49'),
(174, 1, 'admin', 'login', '58.10.135.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-21 23:06:30'),
(175, 0, 'admin', 'login_failed', '58.10.135.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-21 23:06:30'),
(176, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-23 11:17:10'),
(177, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-23 11:17:10'),
(178, 1, 'admin', 'login', '49.237.169.115', 'Mozilla/5.0 (Linux; Android 15; SM-A556E Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.52 Mobile Safari/537.36 Line/15.15.1/IAB', '2025-09-24 07:13:15'),
(179, 0, 'admin', 'login_failed', '49.237.169.115', 'Mozilla/5.0 (Linux; Android 15; SM-A556E Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.52 Mobile Safari/537.36 Line/15.15.1/IAB', '2025-09-24 07:13:15'),
(180, 1, 'admin', 'login', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 10:59:47'),
(181, 0, 'admin', 'login_failed', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 10:59:47'),
(182, 1, 'admin', 'logout', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 11:40:53'),
(183, 1, 'admin', 'login', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 11:41:05'),
(184, 0, 'admin', 'login_failed', '49.237.12.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-24 11:41:05'),
(185, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 10:01:52'),
(186, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 10:01:53'),
(187, 2, 'user', 'login', '27.145.145.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 10:44:58'),
(188, 0, 'user', 'login_failed', '27.145.145.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-14 10:44:58'),
(189, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 15:16:39'),
(190, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 15:17:08'),
(191, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-14 15:17:08'),
(192, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-10-14 15:19:36'),
(193, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-10-14 15:19:36'),
(194, 1, 'admin', 'login', '182.232.45.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-15 17:26:31'),
(195, 0, 'admin', 'login_failed', '182.232.45.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-15 17:26:31'),
(196, 1, 'admin', 'login', '182.232.39.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 10:20:23'),
(197, 0, 'admin', 'login_failed', '182.232.39.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 10:20:23'),
(198, 1, 'admin', 'login', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 22:16:06'),
(199, 0, 'admin', 'login_failed', '182.232.41.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-16 22:16:06'),
(200, 1, 'admin', 'login', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 10:50:58'),
(201, 0, 'admin', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 10:50:58'),
(202, 1, 'admin', 'login', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 12:39:39'),
(203, 0, 'admin', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 12:39:40'),
(204, 1, 'admin', 'login', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 13:18:00'),
(205, 0, 'admin', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 13:18:00'),
(206, 2, 'user', 'login', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:04'),
(207, 0, 'user', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:04'),
(208, 2, 'user', 'login', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:04'),
(209, 0, 'user', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:05'),
(210, 2, 'user', 'login', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:07'),
(211, 0, 'user', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:07'),
(212, 2, 'user', 'login', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:08'),
(213, 0, 'user', 'login_failed', '182.232.40.138', 'Mozilla/5.0 (Linux; Android 15; SM-S928B Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.43 Mobile Safari/537.36 Line/15.16.2/IAB', '2025-10-17 13:25:08'),
(214, 1, 'admin', 'login', '182.232.42.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 21:16:46'),
(215, 0, 'admin', 'login_failed', '182.232.42.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-17 21:16:47'),
(216, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:14:44'),
(217, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:17:44'),
(218, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:18:30'),
(219, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:19:02'),
(220, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:19:58'),
(221, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:20:52'),
(222, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:22:00'),
(223, 0, 'smartict@gmail.com', 'login_failed', '49.229.208.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 16:23:37'),
(224, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 09:15:03'),
(225, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 09:15:03'),
(226, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 16:31:17'),
(227, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-26 16:31:17'),
(228, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 18:07:19'),
(229, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 18:07:19'),
(230, 1, 'admin', 'login', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:19:31'),
(231, 0, 'admin', 'login_failed', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:19:31'),
(232, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:25:36'),
(233, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:25:40'),
(234, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:25:40'),
(235, 1, 'admin', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:33'),
(236, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:41'),
(237, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:41'),
(238, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:43'),
(239, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:43'),
(240, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:44'),
(241, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:44'),
(242, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:46'),
(243, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:46'),
(244, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:47'),
(245, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:47'),
(246, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:50'),
(247, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:50'),
(248, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:50'),
(249, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:31:50'),
(250, 1, 'admin', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:32:40'),
(251, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:33:16'),
(252, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-27 19:33:16'),
(253, 1, 'admin', 'logout', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:37:50'),
(254, 2, 'user', 'login', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:38:00'),
(255, 0, 'user', 'login_failed', '49.229.184.216', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:38:00'),
(256, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 19:46:47'),
(257, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 19:46:47'),
(258, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 19:46:50'),
(259, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-03-27 19:46:50'),
(260, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:56:26'),
(261, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-27 19:56:26'),
(262, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:01:38'),
(263, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:01:38'),
(264, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:18:19'),
(265, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:18:19'),
(266, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:35:29'),
(267, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:35:29'),
(268, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:42:07'),
(269, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 09:42:07'),
(270, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 10:58:53');
INSERT INTO `log_login` (`id`, `user_id`, `username`, `action`, `ip_address`, `user_agent`, `log_time`) VALUES
(271, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 10:58:53'),
(272, 2, 'user', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 11:00:06'),
(273, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 11:00:51'),
(274, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 11:00:51'),
(275, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 11:01:09'),
(276, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 11:01:09'),
(277, 2, 'user', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 12:07:29'),
(278, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 12:29:26'),
(279, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 12:29:26'),
(280, 0, 'admin', 'login_failed', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 12:58:55'),
(281, 1, 'admin', 'login', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 12:59:13'),
(282, 0, 'admin', 'login_failed', '27.145.110.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-28 12:59:13'),
(283, 1, 'admin', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 13:05:53'),
(284, 2, 'user', 'login', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-28 13:06:25'),
(285, 0, 'user', 'login_failed', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-28 13:06:25'),
(286, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 13:06:42'),
(287, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 13:06:53'),
(288, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 13:06:53'),
(289, 2, 'user', 'login', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', '2026-03-28 13:10:02'),
(290, 0, 'user', 'login_failed', '49.237.189.251', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', '2026-03-28 13:10:02'),
(291, 1, 'admin', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:00:48'),
(292, 0, 'ST01', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:01:01'),
(293, 0, 'ST01', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:01:17'),
(294, 0, 'ST01', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:01:47'),
(295, 0, 'ST01', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:02:04'),
(296, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:03:16'),
(297, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-28 14:03:16'),
(298, 1, 'admin', 'login', '49.229.218.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 20:37:12'),
(299, 0, 'admin', 'login_failed', '49.229.218.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-29 20:37:12'),
(300, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 08:49:34'),
(301, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 08:49:34'),
(302, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:09:34'),
(303, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:08'),
(304, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:08'),
(305, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:13'),
(306, 0, 'Earth', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:21'),
(307, 0, 'Earth', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:33'),
(308, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:39'),
(309, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:10:39'),
(310, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-30 09:20:46'),
(311, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-30 09:20:46'),
(312, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:20:50'),
(313, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:20:50'),
(314, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:38:28'),
(315, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 09:38:28'),
(316, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:25:17'),
(317, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:25:24'),
(318, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:25:24'),
(319, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:26:54'),
(320, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:26:58'),
(321, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:26:58'),
(322, 2, 'user', 'login', '49.237.107.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 10:28:41'),
(323, 0, 'user', 'login_failed', '49.237.107.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 10:28:41'),
(324, 0, 'User', 'login_failed', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 10:30:38'),
(325, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:31:33'),
(326, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 10:31:33'),
(327, 2, 'user', 'login', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 10:31:57'),
(328, 0, 'user', 'login_failed', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 10:31:57'),
(329, 2, 'user', 'login', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 10:31:59'),
(330, 0, 'user', 'login_failed', '49.230.146.28', 'Mozilla/5.0 (Linux; Android 16; SM-A166P Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.119 Mobile Safari/537.36 Line/26.3.1/IAB', '2026-03-30 10:31:59'),
(331, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 13:19:30'),
(332, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 13:19:30'),
(333, 1, 'admin', 'login', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 14:23:29'),
(334, 0, 'admin', 'login_failed', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 14:23:29'),
(335, 1, 'admin', 'login', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 14:23:31'),
(336, 0, 'admin', 'login_failed', '49.229.213.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Safari Line/26.2.0', '2026-03-30 14:23:31'),
(337, 2, 'user', 'login', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 17:09:16'),
(338, 0, 'user', 'login_failed', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 17:09:16'),
(339, 2, 'user', 'logout', '58.136.249.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-30 17:09:46'),
(340, 2, 'user', 'login', '49.0.69.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-31 09:21:43'),
(341, 0, 'user', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', '2026-03-31 09:21:43'),
(342, 2, 'user', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 09:40:24'),
(343, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 09:40:37'),
(344, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 09:40:37'),
(345, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 12:54:51'),
(346, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 12:54:58'),
(347, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-31 12:54:58'),
(348, 2, 'user', 'login', '27.145.110.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-04-01 17:17:34'),
(349, 0, 'user', 'login_failed', '27.145.110.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-04-01 17:17:34'),
(350, 0, 'superadmin01', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 10:15:09'),
(351, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 10:15:20'),
(352, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-30 10:15:20'),
(353, 0, 'Superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:48:40'),
(354, 0, 'Superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:48:41'),
(355, 0, 'Superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:48:43'),
(356, 0, 'superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:49:01'),
(357, 0, 'superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:49:03'),
(358, 0, 'superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:49:05'),
(359, 0, 'Superadmin01', 'login_failed', '27.145.141.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 16:49:25'),
(360, 0, 'superadmin01', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 14:30:32'),
(361, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 14:30:40'),
(362, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 14:30:40'),
(363, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 09:22:58'),
(364, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 09:22:58'),
(365, 1, 'admin', 'login', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:08:38'),
(366, 0, 'admin', 'login_failed', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:08:38'),
(367, 1, 'admin', 'login', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:25'),
(368, 0, 'admin', 'login_failed', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:25'),
(369, 1, 'admin', 'logout', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:32'),
(370, 1, 'admin', 'login', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:39'),
(371, 0, 'admin', 'login_failed', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:39'),
(372, 1, 'admin', 'logout', '192.168.1.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-08 16:09:58'),
(373, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 16:29:44'),
(374, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 16:29:44'),
(375, 0, 'superadmin01', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-06 09:49:09'),
(376, 1, 'admin', 'login', '27.145.145.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-07 09:58:17'),
(377, 0, 'admin', 'login_failed', '27.145.145.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-07 09:58:17'),
(378, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-07 09:59:06'),
(379, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-07 09:59:06'),
(380, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:08:05'),
(381, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:08:14'),
(382, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:08:14'),
(383, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:08:52'),
(384, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:30:03'),
(385, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-14 14:30:03'),
(386, 0, 'superadmin01', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 11:51:11'),
(387, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 11:51:19'),
(388, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-18 11:51:19'),
(389, 1, 'admin', 'login', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:19:32'),
(390, 0, 'admin', 'login_failed', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:19:32'),
(391, 1, 'admin', 'logout', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:42:46'),
(392, 2, 'user', 'login', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:42:52'),
(393, 0, 'user', 'login_failed', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:42:52'),
(394, 2, 'user', 'logout', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:43:10'),
(395, 1, 'admin', 'login', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:43:17'),
(396, 0, 'admin', 'login_failed', '49.237.65.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 21:43:17'),
(397, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 09:22:19'),
(398, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 09:22:19'),
(399, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-20 14:29:14'),
(400, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-20 14:29:14'),
(401, 1, 'admin', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 09:44:35'),
(402, 0, 'admin', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 09:44:35'),
(403, 1, 'admin', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:22:56'),
(404, 2, 'user', 'login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:23:05'),
(405, 0, 'user', 'login_failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:23:05'),
(406, 2, 'user', 'logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:25:41'),
(407, 0, 'bancha', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:50:17'),
(408, 3, 'Admin02', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:50:30'),
(409, 0, 'Admin02', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:50:30'),
(410, 3, 'Admin02', 'logout', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:51:11'),
(411, 1, 'admin', 'login', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:51:17'),
(412, 0, 'admin', 'login_failed', '49.0.69.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-22 11:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_set_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('single_choice','multiple_choice','true_false','short_answer') DEFAULT 'multiple_choice',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_set_id`, `question_text`, `question_type`, `created_at`) VALUES
(1, 3, 'What choice is correct?', 'multiple_choice', '2025-04-07 17:40:46'),
(2, 3, ' 1 + 1 / 1 = ?', 'multiple_choice', '2025-04-29 14:16:17'),
(3, 4, '490 + 590', 'multiple_choice', '2025-05-02 14:04:28'),
(4, 4, 'what is A if B<A but A > C and B != C', 'multiple_choice', '2025-05-02 14:04:35'),
(5, 4, '700/100 = ?', 'multiple_choice', '2025-05-02 14:04:35'),
(6, 4, 'what is plus (+)? ', 'multiple_choice', '2025-05-02 14:04:35'),
(7, 5, 'tree', 'multiple_choice', '2025-05-02 15:02:15'),
(8, 5, 'Too', 'multiple_choice', '2025-05-02 15:02:15'),
(9, 6, 'python คืออะไร?', 'multiple_choice', '2025-05-24 14:58:44'),
(10, 6, 'ข้อใดคือไฟล์นามสกุลที่ใช้สำหรับเขียนโปรแกรมภาษา Python?', 'multiple_choice', '2025-05-24 14:58:44'),
(11, 7, '่เ้่า่', 'multiple_choice', '2025-10-14 11:04:07'),
(12, 8, 'การรวบรวมข้อมูลคลังสินค้ามีจุดประสงค์หลักเพื่ออะไร', 'multiple_choice', '2025-10-16 22:55:37'),
(13, 8, 'การจัดทำแผนการปฏิบัติงานคลังสินค้ารวมถึงกิจกรรมใดบ้าง', 'multiple_choice', '2025-10-16 22:55:37'),
(14, 8, 'ระบบ ERP (Enterprise Resource Planning) มีบทบาทอย่างไรในการจัดการคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(15, 8, 'ระบบ WMS (Warehouse Management System) มีหน้าที่หลักอะไร', 'multiple_choice', '2025-10-16 22:55:37'),
(16, 8, 'เทคโนโลยี RFID (Radio Frequency Identification) มีข้อดีอย่างไรในการจัดการคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(17, 8, 'ระบบ Barcode ถูกนำมาใช้ประโยชน์อย่างไรในการจัดการคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(18, 8, ' เทคโนโลยีใดที่ช่วยให้ทราบตำแหน่งที่ตั้งของสินค้าคงคลังแบบเรียลไทม์', 'multiple_choice', '2025-10-16 22:55:37'),
(19, 8, 'ข้อใดคือประโยชน์ของการนำเทคโนโลยีมาใช้ในการจัดการคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(20, 8, 'ในการวางแผนการจัดการคลังสินค้าด้วยเทคโนโลยี สิ่งแรกที่ควรพิจารณาคืออะไร', 'multiple_choice', '2025-10-16 22:55:37'),
(21, 8, 'ตัวชี้วัดใดที่แสดงถึงประสิทธิภาพในการใช้พื้นที่จัดเก็บสินค้าในคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(22, 8, 'ระบบจัดเก็บสินค้าอัตโนมัติ (AS/RS) ช่วยลดข้อผิดพลาดที่เกิดจากอะไร', 'multiple_choice', '2025-10-16 22:55:37'),
(23, 8, 'เทคโนโลยีใดที่เหมาะสำหรับการติดตามสินค้าที่มีมูลค่าสูงและต้องการความปลอดภัยเป็นพิเศษ', 'multiple_choice', '2025-10-16 22:55:37'),
(24, 8, 'การฝึกอบรมพนักงานให้มีความรู้ความเข้าใจในการใช้เทคโนโลยีใหม่ในคลังสินค้ามีความสำคัญอย่างไร', 'multiple_choice', '2025-10-16 22:55:37'),
(25, 8, 'ระบบจัดการคลังสินค้า (WMS) มีหน้าที่หลักในการจัดการกระบวนการใด', 'multiple_choice', '2025-10-16 22:55:37'),
(26, 8, 'เทคโนโลยีใดที่ใช้คลื่นวิทยุในการระบุและติดตามสินค้าแบบไร้สัมผัส', 'multiple_choice', '2025-10-16 22:55:37'),
(27, 8, 'ระบบ Pick-to-Light ช่วยเพิ่มประสิทธิภาพในกระบวนการใด', 'multiple_choice', '2025-10-16 22:55:37'),
(28, 8, 'การประเมินผลการนำเทคโนโลยีมาใช้ในการจัดการคลังสินค้าควรพิจารณาจากอะไร', 'multiple_choice', '2025-10-16 22:55:37'),
(29, 8, 'เทคโนโลยีใดที่ช่วยในการจัดการสินค้าคงคลังแบบ Just-in-Time (JIT) ได้อย่างมีประสิทธิภาพ', 'multiple_choice', '2025-10-16 22:55:37'),
(30, 8, 'เทคโนโลยีใดที่ช่วยในการรักษาความปลอดภัยของสินค้าในคลังสินค้า', 'multiple_choice', '2025-10-16 22:55:37'),
(31, 8, 'คลังสินค้า (Warehouse) คือ สถานที่ที่ใช้ในการจัดเก็บสินค้าให้อยู่ในสภาพดี มีคุณสมบัติที่จะส่งมอบให้กับบุคคล องค์กร หรือหน่วยงานที่ต้องการสินค้านั้น', 'multiple_choice', '2025-10-16 22:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `question_sets`
--

CREATE TABLE `question_sets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('pre-test','post-test','quiz') NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `exam_period` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_sets`
--

INSERT INTO `question_sets` (`id`, `title`, `type`, `description`, `start_time`, `exam_period`, `created_at`, `is_deleted`) VALUES
(3, 'Science Math', 'pre-test', 'prepare test before learning.', '2025-04-04 17:40:00', 60, '2025-04-07 17:40:41', 0),
(4, 'post Math', 'post-test', 'this is last exam for term will be more...', '2025-05-02 13:57:00', 30, '2025-05-02 14:04:25', 0),
(5, 'Quiz midterm', 'quiz', 'Quiz midterm Description.', '2025-05-02 15:00:00', 10, '2025-05-02 15:02:15', 0),
(6, 'python Test', 'pre-test', 'แบบทดสอบความรู้เกี่ยวกับภาษา python สำหรับผู้เริ่มต้น', '2025-05-31 14:45:00', 10, '2025-05-24 14:58:44', 0),
(7, 'ดดดดดดดดดดดดด', 'pre-test', 'ดก', '2025-10-14 00:09:00', 60, '2025-10-14 11:04:07', 1),
(8, 'แบบทดสอบก่อนเรียน ชุดปฏิบัติการจำลองระบบโลจิสติกส์', 'pre-test', 'ในการทำธุรกิจหลายๆ ท่านอาจจะเคยรู้จักกับระบบ WMS กันมาบ้าง ซึ่งระบบจัดการคลังสินค้า WMS เป็นเครื่องมือสำคัญในการจัดการคลังสินค้าให้มีประสิทธิภาพ ทั้งการรับสินค้า การจัดเก็บสินค้าเข้าคลัง การตรวจนับสินค้าคงคลัง การจัดสรรพื้นที่ภายในคลังสินค้า รวมถึงการจัดส่งสินค้าไปถึงมือลูกค้า', '2025-10-16 22:26:00', 60, '2025-10-16 22:55:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_set_id` int(11) NOT NULL,
  `score` float DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token_line`
--

CREATE TABLE `token_line` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
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
(4, 'PDF', '2025-03-06', '2025-03-06', 0),
(5, 'Activity', '2025-04-21', '2025-04-21', 0),
(6, '3D model', '2025-04-21', '2025-04-21', 0),
(7, 'Examination / Quiz', '2025-04-29', '2025-04-29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
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
(35, 1, 'Module 1: Introduction to Python', 'เริ่มต้นทำความรู้จักกับภาษา Python ว่าคืออะไร ใช้ทำอะไร และทำไมถึงเป็นภาษาที่นิยมมากในปัจจุบัน', 'ผู้เรียนจะสามารถเริ่มต้นใช้งาน Python และเข้าใจโครงสร้างพื้นฐานของภาษาได้', '2026-03-31', '2026-03-31', 0),
(36, 1, 'Module 2: Let\'s started', '', '', '2026-05-21', '2026-05-21', 0),
(37, 14, 'บทที่ 1 การเขียนโปรแกรมเบื้องต้น', 'เป็นซอฟต์แวร์วิศวกรรมขั้นสูงสำหรับการเขียนโปรแกรม PLC, ระบบ SCADA และการจำลองกระบวนการแบบ 3 มิติ (3D process simulation)', '', '2026-07-19', '2026-07-19', 0);

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
  `password` varchar(255) NOT NULL,
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
(1, '65000000001', 'Jirawat Sisaard Reef', 'Jirawat@gmail.com', 'admin', '$2y$10$5ugU0G0PNItAUaXvYByCluOgBAeHtYOxJYsRzkAoXRI7qvDMfBLcC', 0, '0987654321', '2025-03-03', '2025-06-04', 0, 1, 0),
(2, '65000000002', 'Newbie olded gika', 'newbie@gmail.com', 'user', '$2y$10$wslMcLnILqmTeUYJQVFkReFv9P3AExaWnanXAWl9LSa0pd39tNQhC', 1, '0984634583', '2025-04-04', '2025-06-04', 0, 0, 0),
(3, '65000000003', 'Admin_02', 'admin02@gmail.com', 'Admin02', '$2y$10$TE7aLS1.L4BpjYycEjMeUO8m6YVOZKnRsK/iY70lXi8At0QgYk/T6', 0, '0123456789', '2025-03-03', '2025-06-04', 0, 1, 0),
(5, '65000000004', 'Kanya Sukseree Queen', 'Kanya@gmail.com', 'Kanya.S.Admin', '$2y$10$cII.h9R/RjoXOSjDLs4PauxcARXZHAH2lPQnaaYP6fTUla4hbW15C', 0, '0123456789', '2025-03-03', '2025-06-04', 0, 1, 0),
(6, '65000000005', 'Nichaporn Treesup Cha-em', 'Nichaporn@gmail.com', 'Nichaporn.T.User', '$2y$10$5Dr9lTvpxyFVSrDvz6mHFOKE88qJL7biGKBpDuV/H0vQp86qEJTaC', 0, '123456789', '2025-04-03', '2025-06-04', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `answered_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `exam_id`, `question_id`, `choice_id`, `answer_text`, `answered_at`) VALUES
(49, 1, 3, 1, 2, NULL, '2025-05-02 15:10:40'),
(50, 1, 3, 2, 7, NULL, '2025-05-02 15:10:40'),
(51, 1, 4, 3, 10, NULL, '2025-05-02 15:11:36'),
(52, 1, 4, 4, 15, NULL, '2025-05-02 15:11:36'),
(53, 1, 4, 5, 17, NULL, '2025-05-02 15:11:36'),
(54, 1, 4, 6, 22, NULL, '2025-05-02 15:11:36'),
(63, 1, 5, 7, 25, NULL, '2025-05-21 15:02:18'),
(64, 1, 5, 8, 30, NULL, '2025-05-21 15:02:18'),
(65, 1, 8, 12, 45, NULL, '2025-10-17 12:43:32'),
(66, 1, 8, 13, 51, NULL, '2025-10-17 12:43:32'),
(67, 1, 8, 14, 54, NULL, '2025-10-17 12:43:33'),
(68, 1, 8, 15, 56, NULL, '2025-10-17 12:43:33'),
(69, 1, 8, 16, 61, NULL, '2025-10-17 12:43:33'),
(70, 1, 8, 17, 66, NULL, '2025-10-17 12:43:33'),
(71, 1, 8, 18, 69, NULL, '2025-10-17 12:43:33'),
(72, 1, 8, 19, 74, NULL, '2025-10-17 12:43:33'),
(73, 1, 8, 20, 76, NULL, '2025-10-17 12:43:33'),
(74, 1, 8, 21, 82, NULL, '2025-10-17 12:43:33'),
(75, 1, 8, 22, 87, NULL, '2025-10-17 12:43:33'),
(76, 1, 8, 23, 90, NULL, '2025-10-17 12:43:33'),
(77, 1, 8, 24, 93, NULL, '2025-10-17 12:43:33'),
(78, 1, 8, 25, 98, NULL, '2025-10-17 12:43:33'),
(79, 1, 8, 26, 101, NULL, '2025-10-17 12:43:33'),
(80, 1, 8, 27, 105, NULL, '2025-10-17 12:43:33'),
(81, 1, 8, 28, 108, NULL, '2025-10-17 12:43:33'),
(82, 1, 8, 29, 113, NULL, '2025-10-17 12:43:33'),
(83, 1, 8, 30, 116, NULL, '2025-10-17 12:43:33'),
(84, 1, 8, 31, 120, NULL, '2025-10-17 12:43:33'),
(85, 1, 6, 9, 34, NULL, '2026-05-21 15:54:24'),
(86, 1, 6, 10, 40, NULL, '2026-05-21 15:54:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_access`
--
ALTER TABLE `chat_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_room_id__fk` (`chat_room_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_room_id` (`chat_room_id`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

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
-- Indexes for table `course_points`
--
ALTER TABLE `course_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `unit_id` (`unit_id`);

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
  ADD KEY `owner_id_course_student__id_user` (`owner_id`);

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
-- Indexes for table `home_profile`
--
ALTER TABLE `home_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_action`
--
ALTER TABLE `log_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_error`
--
ALTER TABLE `log_error`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_set_id` (`question_set_id`);

--
-- Indexes for table `question_sets`
--
ALTER TABLE `question_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_set_id` (`question_set_id`);

--
-- Indexes for table `token_line`
--
ALTER TABLE `token_line`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `choice_id` (`choice_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_access`
--
ALTER TABLE `chat_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_access`
--
ALTER TABLE `course_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `course_points`
--
ALTER TABLE `course_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_schedule`
--
ALTER TABLE `course_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_profile`
--
ALTER TABLE `home_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_action`
--
ALTER TABLE `log_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT for table `log_error`
--
ALTER TABLE `log_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `question_sets`
--
ALTER TABLE `question_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token_line`
--
ALTER TABLE `token_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typefile`
--
ALTER TABLE `typefile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_access`
--
ALTER TABLE `chat_access`
  ADD CONSTRAINT `chat_room_id__fk` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`),
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`);

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

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
-- Constraints for table `course_points`
--
ALTER TABLE `course_points`
  ADD CONSTRAINT `course_points_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `course_points_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_points_ibfk_3` FOREIGN KEY (`exam_id`) REFERENCES `question_sets` (`id`),
  ADD CONSTRAINT `course_points_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

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
  ADD CONSTRAINT `course_id_course_student__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `owner_id_course_student__id_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);

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
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`question_set_id`) REFERENCES `question_sets` (`id`);

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `test_results_ibfk_2` FOREIGN KEY (`question_set_id`) REFERENCES `question_sets` (`id`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `course_id_unit__id_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_3` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_4` FOREIGN KEY (`exam_id`) REFERENCES `question_sets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
