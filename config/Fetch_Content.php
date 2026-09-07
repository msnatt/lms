<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รองรับ course_id (optional) เพื่อกรองเฉพาะ content ของบทในคอร์สนั้น ๆ — ไม่ส่งมา = คืนทั้งหมดเหมือนเดิม
$course_id = isset($_GET['course_id']) && is_numeric($_GET['course_id']) ? (int) $_GET['course_id'] : null;

$options = [];

if ($course_id !== null) {
    $sql = "SELECT content.* FROM content
            JOIN unit ON content.unit_id = unit.id
            WHERE content.is_deleted = 0 AND unit.is_deleted = 0 AND unit.course_id = ?
            ORDER BY content.unit_id, content.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
    $stmt->close();
} else {
    // ดึงข้อมูลจากตาราง categories
    $sql = "SELECT * FROM content WHERE is_deleted = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row; // เก็บข้อมูลในรูปแบบ Array
        }
    }
}

// ส่งข้อมูลกลับในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($options);

// ปิดการเชื่อมต่อ
$conn->close();
?>
