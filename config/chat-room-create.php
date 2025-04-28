<?php
session_start();
include "../config/no-crash.php";
include "../config/connect.php";

header('Content-Type: application/json');

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $room_name = trim($data['room_name'] ?? '');

    if (empty($room_name)) {
        echo json_encode(["success" => false, "message" => "Room name is required"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO chat_rooms (name) VALUES (?)");
        $stmt->bind_param("s", $room_name);
        $stmt->execute();

        $room_id = $stmt->insert_id; // เอา ID ห้องที่พึ่งสร้าง

        echo json_encode(["success" => true, "room_id" => $room_id]);

    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

$conn->close();
exit;
?>
