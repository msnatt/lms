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

$userid = $_GET['id'];
if (!$userid) {
    echo json_encode(["success" => false, "message" => "need parameter id."]);
    exit;
}


// ดึงข้อมูลจากตาราง categories
$sql = "SELECT * FROM chat_access WHERE is_deleted = 0 AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$userid);
$stmt->execute();
$result = $stmt->get_result();
// $result = $conn->query($sql);

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
