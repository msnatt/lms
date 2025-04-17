<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "../config/no-crash.php";
include "../config/connect.php";

if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username'];
$user = $_SESSION['user'] ?? 'N/A';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room_id = $_GET['room_id'] ?? 0;

$sql = "SELECT m.id, m.message, m.created_at, u.name 
        FROM chat_messages AS m 
        JOIN user AS u ON m.user_id = u.id 
        WHERE m.chat_room_id = ?
        ORDER BY m.created_at DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

$last_message = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($last_message);
