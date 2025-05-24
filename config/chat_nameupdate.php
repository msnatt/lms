<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username'];
$user = $_SESSION['user'] ?? 'N/A';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // เปิด Transaction
    $conn->begin_transaction();

    try {
        // รับค่าจากฟอร์ม
        $room_id = $_POST['room_id'];
        $new_name = $_POST['new_name'];
        
        // ตรวจสอบว่ามี course_id นี้หรือไม่
        $sql_check_course = "SELECT id FROM chat_rooms WHERE id = ?";
        $stmt = $conn->prepare($sql_check_course);
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // อัปเดตข้อมูล course
            $sql_update = "UPDATE chat_rooms SET name = ? WHERE id = ? ";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("si", $new_name, $room_id);
            $stmt->execute();
        } else {
            die("Error: Course ID not found.");
        }

        // ถ้าทุกอย่างสำเร็จ ให้ commit
        $conn->commit();
         echo json_encode(['status' => 'success', 'message' => 'อัปเดตชื่อห้องสำเร็จ']);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดต']);
    }
}
    
$conn->close();
exit();
