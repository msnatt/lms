<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username'];
$user = $_SESSION['user'] ?? 'N/A';

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สมมุติว่าแชทมี chat_room_id หรือใช้ user_id ก็ได้
$room_id = $_GET['room_id'] ?? 1;

$sql = "SELECT m.id, m.message, m.created_at, u.name 
        FROM chat_messages AS m 
        JOIN user AS u ON m.sender_id = u.id 
        WHERE m.chat_room_id = ?
        ORDER BY m.created_at ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
