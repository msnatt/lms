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
        $newname = $_POST['newname'] ?? null;
        $newusername = $_POST['username'] ?? null;
        $telephone = $_POST['telephone'] ?? null;

        if (!$user_id || !$newname || !$newusername) {
            echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน"]);
            exit();
        }

        // ตรวจสอบว่ามี user นี้หรือไม่
        $sql_check_user = "SELECT id FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql_check_user);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $conn->rollback();
            echo json_encode(["success" => false, "message" => "Error: user ID not found."]);
            exit();
        }

        // ตรวจสอบว่า username ซ้ำกับผู้ใช้อื่นหรือไม่
        $sql_check_username = "SELECT id FROM user WHERE username = ? AND id != ? AND is_deleted = 0";
        $stmt = $conn->prepare($sql_check_username);
        $stmt->bind_param("si", $newusername, $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $conn->rollback();
            echo json_encode(["success" => false, "message" => "usernametaken"]);
            exit();
        }

        // อัปเดตข้อมูล user
        $sql_update_user = "UPDATE user SET name = ?, username = ?, telephone = ?, update_date = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql_update_user);
        $stmt->bind_param("sssi", $newname, $newusername, $telephone, $user_id);
        $stmt->execute();

        // ถ้าทุกอย่างสำเร็จ ให้ commit
        $conn->commit();
        log_action("แก้ไขข้อมูลผู้ใช้ id={$user_id}", "user_management");
        echo json_encode(["success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"]);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
    }
}

$conn->close();
exit();
