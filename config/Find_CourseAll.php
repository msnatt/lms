<?php

session_start();

include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ต้อง login ก่อนถึงดูข้อมูลคอร์สได้ (เดิมไม่มีการเช็คเลย ใครก็ยิงดูคอร์สไหนก็ได้)
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['courseid'] ?? null;

    // ตรวจสอบว่า id เป็นตัวเลข
    if ($id && is_numeric($id)) {
        $user = $_SESSION['user'] ?? [];
        $isAdmin = !empty($user['is_admin']);

        // นักเรียนเห็นเฉพาะคอร์สที่เผยแพร่แล้วหรือเป็นเจ้าของเอง ส่วน admin เห็นทุกสถานะ
        $sql = "SELECT * FROM course WHERE is_deleted = 0 AND id = ?"
            . ($isAdmin ? "" : " AND (is_publish = 1 OR create_by = " . (int)($user['id'] ?? 0) . ")");
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
