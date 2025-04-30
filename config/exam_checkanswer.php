<?php
session_start();
require '../config/connect.php';
header('Content-Type: application/json');


// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $user_id = $_SESSION['user']['id'] ?? null; // ต้องมีการ login เพื่อให้ได้ user_id
    $correct_data = $input['correct_data']; // คำตอบที่ถูกต้องที่ส่งมาจาก frontend

    $exam_id = $correct_data['id'];
    $correct_answers = [];

    // 1. เตรียมคำตอบที่ถูกต้อง
    foreach ($correct_data['questions'] as $question) {
        foreach ($question['choices'] as $choice) {
            if ($choice['choices_is_correct'] == 1) {
                $correct_answers[$question['questions_id']] = $choice['choices_id'];
                break; // คำตอบเดียวที่ถูกต้อง
            }
        }
    }

    // 2. ดึงคำตอบจาก user_answers
    $sql = "SELECT question_id, choice_id FROM user_answers WHERE user_id = ? AND question_id IN (" . implode(',', array_keys($correct_answers)) . ")";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    $correct = 0;

    while ($row = $result->fetch_assoc()) {
        $question_id = $row['question_id'];
        $choice_id = $row['choice_id'];
        $total++;
        if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $choice_id) {
            $correct++;
        }
    }

    echo json_encode([
        'total' => $total,
        'correct' => $correct,
        'score_percent' => $total > 0 ? round(($correct / $total) * 100, 2) : 0
    ]);
}
