<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

$course_id = $_GET['courseid'] ?? null;
if (!$course_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT owner_id FROM course_student WHERE course_id = ? AND is_deleted = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = $row;
}

echo json_encode($options);
$conn->close();
