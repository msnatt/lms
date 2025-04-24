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
        $chat_room_id = $_POST['chat_room_id'];
        $user_id = $_POST['user_id'];

        // บันทึกข้อมูลลงในตาราง course
        $sql = "INSERT INTO chat_access (chat_room_id, user_id, is_deleted) VALUES (?, ?, 0)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing course statement: " . $conn->error);
        }
        $stmt->bind_param("ii", $chat_room_id, $user_id);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }

        $conn->commit();
        echo "บันทึกข้อมูลเรียบร้อย";
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}

$conn->close();
exit();
