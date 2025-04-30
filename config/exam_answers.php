<?php
session_start();
require '../config/connect.php';

header('Content-Type: application/json');

// ตรวจสอบการรับค่าผ่าน POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['exam_id']) || !isset($data['answers'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบ']);
    exit;
}

$user_id = $_SESSION['user']['id'] ?? null; // ต้องมีการ login เพื่อให้ได้ user_id
$exam_id = $data['exam_id'];
$answers = $data['answers'];

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'ยังไม่ได้เข้าสู่ระบบ']);
    exit;
}


// วนลูปคำตอบและบันทึกลงฐานข้อมูล
foreach ($answers as $ans) {
    $question_id = $ans['question_id'];
    $choice_id = $ans['choice_id'] ?? null; // อาจเป็น null ถ้าไม่ได้ตอบ

    $sql_check = "SELECT id FROM user_answers WHERE user_id = ? AND exam_id = ? AND question_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("iii", $user_id, $exam_id, $question_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        // เตรียม SQL
        $sql = "INSERT INTO user_answers (user_id, exam_id, question_id, choice_id, answered_at)
        VALUES (?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiii', $user_id, $exam_id, $question_id, $choice_id);
        $stmt->execute();
    } else {
        echo json_encode(['status' => 'duplicate', 'message' => 'ไม่สามารถส่งแบบทดสอบซ้ำได้']);
        exit;
    }
}

echo json_encode(['status' => 'success', 'message' => 'บันทึกคำตอบเรียบร้อยแล้ว']);
