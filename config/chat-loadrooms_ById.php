<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../config/no-crash.php";
include "../config/connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_list = $_GET['ids'] ?? "";

$ids = array_filter(explode(',', $id_list));
$ids = array_map('intval', $ids);

$options = [];

if (count($ids) > 0) {

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $sql = "SELECT r.*, m.chat_room_id,m.message,m.created_at as m_created_at
            FROM chat_rooms r
            LEFT JOIN chat_messages m 
            ON m.chat_room_id = r.id
            AND m.created_at = (
                SELECT MAX(m2.created_at)
                FROM chat_messages m2
                WHERE m2.chat_room_id = r.id
            )
            WHERE r.id IN ($placeholders)
            AND r.is_deleted = 0
            ";

    $stmt = $conn->prepare($sql);
    $types = str_repeat('i', count($ids));
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
} else {
    echo json_encode(["success" => true, "message" => "No IDs provided", "error" => "No IDs provided"]);
    exit;
}

// ส่ง JSON
header('Content-Type: application/json');
echo json_encode($options);

$conn->close();
