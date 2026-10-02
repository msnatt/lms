<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit();
}

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit();
}

$conn->begin_transaction();

try {
    $user_id = $_POST['user_id'] ?? null;
    $email = $_POST['email'] ?? null;
    $new_password = $_POST['new_password'] ?? null;

    if (!$new_password) {
        echo json_encode(["success" => false, "message" => "กรุณาระบุรหัสผ่านใหม่"]);
        exit();
    }
    if (strlen($new_password) < 8) {
        echo json_encode(["success" => false, "message" => "password_short"]);
        exit();
    }

    if ($user_id) {
        $sql_check_user = "SELECT id FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql_check_user);
        $stmt->bind_param("i", $user_id);
    } elseif ($email) {
        $sql_check_user = "SELECT id FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql_check_user);
        $stmt->bind_param("s", $email);
    } else {
        echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน"]);
        exit();
    }

    $stmt->execute();
    $stmt->store_result();

    // ดึง id ถ้าพบจาก email
    if ($email) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
    }

    if ($stmt->num_rows > 0) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $sql_update_user = "UPDATE user SET password = ?, update_date = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql_update_user);
        $stmt->bind_param("si", $hashedPassword, $user_id);
        $stmt->execute();
    } else {
        $conn->rollback();
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "user ID not found"]);
        exit();
    }

    $conn->commit();
    echo json_encode(["success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
}

$conn->close();
exit();
