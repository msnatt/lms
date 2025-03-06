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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['courseid'] ?? null;

    // ตรวจสอบว่า id เป็นตัวเลข
    if ($id && is_numeric($id)) {
        // เตรียม SQL statement แบบ prepared statement
        $sql = "SELECT * FROM course WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // ผูกพารามิเตอร์
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            // ดึงข้อมูลจากฐานข้อมูล
            $options = [];
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }

            // ส่งข้อมูลเป็น JSON
            header('Content-Type: application/json');
            echo json_encode($options);

            // ปิด statement
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Failed to prepare statement']);
        }
    } else {
        echo json_encode(['error' => 'Invalid course ID']);
    }
}

// ปิดการเชื่อมต่อ
$conn->close();
