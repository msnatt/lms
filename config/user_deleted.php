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
        $user_id = $_POST['user_id'] ?? null;

        if (!$user_id) {
            echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน"]);
            exit();
        }

        // ตรวจสอบว่ามี course_id นี้หรือไม่
        $sql_check_user = "SELECT id FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql_check_user);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // อัปเดตข้อมูล course
            $sql_update_user = "UPDATE user SET is_deleted = 1, update_date = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql_update_user);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        } else {
            die("Error: user ID not found.");
        }

        // ถ้าทุกอย่างสำเร็จ ให้ commit
        $conn->commit();
        echo json_encode(["success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"]);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo json_encode(["success" => true, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
    }
}

$conn->close();
exit();
