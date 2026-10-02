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

    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน"]);
        exit();
    }

    // กันลบบัญชีตัวเอง
    if ((int) $user_id === (int) ($_SESSION['user']['id'] ?? 0)) {
        $conn->rollback();
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "cannot_delete_self"]);
        exit();
    }

    // มี user นี้จริงไหม + เป็น admin ไหม
    $stmt = $conn->prepare("SELECT is_admin FROM user WHERE id = ? AND is_deleted = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($target_is_admin);
    if (!$stmt->fetch()) {
        $stmt->close();
        $conn->rollback();
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "user ID not found"]);
        exit();
    }
    $stmt->close();

    // กันลบแอดมินคนสุดท้าย
    if ((int) $target_is_admin === 1) {
        $res = $conn->query("SELECT COUNT(*) AS c FROM user WHERE is_admin = 1 AND is_deleted = 0");
        $adminCount = (int) $res->fetch_assoc()['c'];
        if ($adminCount <= 1) {
            $conn->rollback();
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "cannot_delete_last_admin"]);
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE user SET is_deleted = 1, update_date = NOW() WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
}

$conn->close();
exit();
