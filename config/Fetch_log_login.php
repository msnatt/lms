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

// ดึงข้อมูลจากตาราง log_login เรียงล่าสุดก่อน จำกัด 500 แถวกันหน้าโหลดหนักเกินไป
$sql = "SELECT id, username, action, ip_address, log_time FROM log_login ORDER BY log_time DESC, id DESC LIMIT 500";
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
