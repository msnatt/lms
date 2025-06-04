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
        $exam_id = $_POST['id'] ?? null;

        if (!$exam_id) {
            echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน"]);
            exit();
        }

        // ตรวจสอบว่ามี course_id นี้หรือไม่
        $sql_check = "SELECT id FROM question_sets WHERE id = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("i", $exam_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // อัปเดตข้อมูล course
            $sql_update = "UPDATE question_sets SET is_deleted = 1 WHERE id = ?";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("i", $exam_id);
            $stmt->execute();
        } else {
            echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
        }

        // ถ้าทุกอย่างสำเร็จ ให้ commit
        $conn->commit();
        echo json_encode(["success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"]);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
    }
}

$conn->close();
exit();
