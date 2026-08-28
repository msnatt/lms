<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เฉพาะ admin เท่านั้นที่อ่าน log ได้ — ป้องกันการยิง URL ตรงเข้ามาโดยไม่ล็อกอิน
if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

// ดึงข้อมูลจากตาราง log_action เรียงล่าสุดก่อน จำกัด 500 แถวกันหน้าโหลดหนักเกินไป
$sql = "SELECT id, category, message, username, ip_address, created_at FROM log_action ORDER BY created_at DESC, id DESC LIMIT 500";
$result = $conn->query($sql);

$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row; // เก็บข้อมูลในรูปแบบ Array
    }
}

// ส่งข้อมูลกลับในรูปแบบ JSON
echo json_encode($options);

// ปิดการเชื่อมต่อ
$conn->close();
?>
