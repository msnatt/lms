<?php

session_start();

include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ต้อง login ก่อนถึงดูรายการชุดข้อสอบได้
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

// ดึงข้อมูลจากตาราง question_sets พร้อมจำนวนคำถามต่อชุด
$sql = "SELECT qs.*,
               (SELECT COUNT(*) FROM questions q WHERE q.question_set_id = qs.id) AS question_count
        FROM question_sets qs
        WHERE qs.is_deleted = 0
        ORDER BY qs.created_at DESC";
$result = $conn->query($sql);

$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row; // เก็บข้อมูลในรูปแบบ Array
    }
}

// ส่งข้อมูลกลับในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($options);

// ปิดการเชื่อมต่อ
$conn->close();
?>
