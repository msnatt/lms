<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method_not_allowed"]);
    exit;
}

$course_id = (int)($_POST['course_id'] ?? 0);
$owner_id = (int)($_POST['owner_id'] ?? 0);

if (!$course_id || !$owner_id) {
    echo json_encode(["success" => false, "message" => "invalid_request"]);
    exit;
}

// ถอนสมาชิกออกจากคอร์สนี้เท่านั้น (soft delete บน course_student) — ไม่แตะบัญชีผู้ใช้เลย
// ต่างจาก config/user_deleted.php เดิมที่ปุ่มนี้เคยเรียก ซึ่งลบบัญชีผู้ใช้ทั้งระบบ
$sql = "UPDATE course_student SET is_deleted = 1, update_date = NOW() WHERE course_id = ? AND owner_id = ? AND is_deleted = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $owner_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    log_action("ถอนผู้เรียน user_id={$owner_id} ออกจากคอร์ส id={$course_id}", "student_management");
    echo json_encode(["success" => true, "message" => "studentremoved"]);
} else {
    echo json_encode(["success" => false, "message" => "savefailed"]);
}

$stmt->close();
$conn->close();
