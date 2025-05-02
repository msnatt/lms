<?php
require '../config/connect.php';
header('Content-Type: application/json');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

try {
    // รับค่าจาก FormData
    $score_percent = $_POST['score_percent'] ?? null;
    $correct = $_POST['correct'] ?? null;
    $total = $_POST['total'] ?? null;
    $course_id = $_POST['course_id'] ?? null;
    $unit_id = $_POST['unit_id'] ?? null;
    $exam_id = $_POST['exam_id'] ?? null;

    // ตรวจสอบข้อมูลว่าครบหรือไม่
    if ($score_percent === null || $correct === null || $total === null || $course_id === null || $unit_id === null) {
        throw new Exception("ข้อมูลไม่ครบถ้วน");
    }

    // สมมุติว่าคุณมี user_id มาจาก session
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        throw new Exception("ไม่พบข้อมูลผู้ใช้งาน");
    }

    // เตรียม SQL สำหรับ INSERT
    // ทำการอัปเดตข้อมูล
    $sql =  "UPDATE course_points 
     SET point = ?, total = ? WHERE user_id = ? AND course_id = ? AND unit_id = ? AND exam_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiii", $correct, $total, $user_id, $course_id, $unit_id, $exam_id);

    if (!$stmt->execute()) {
        throw new Exception("เกิดข้อผิดพลาดในการบันทึกคะแนน: " . $stmt->error);
    }

    echo json_encode(['status' => 'success', 'message' => 'บันทึกคะแนนเรียบร้อยแล้ว']);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
