<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['user_id'] ?? null;

    if ($user_id) {
        $sql = "SELECT * FROM course_student WHERE is_deleted = 0 AND owner_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // สร้าง array เพื่อเก็บข้อมูลที่ได้
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            // แสดงผลข้อมูลเป็น JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);

            $stmt->close();
        } else {
            // ถ้า prepare ไม่สำเร็จ
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to prepare statement.'
            ]);
        }
    } else {
        // ไม่มี user_id
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'User ID is required.'
        ]);
    }
}
$conn->close();
