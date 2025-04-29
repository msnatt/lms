<?php
require '../config/connect.php';
header('Content-Type: application/json');


// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // รับค่าหลัก
    $title = $_POST['title'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $examPeriod = $_POST['examPeriod'] ?? '';
    $description = $_POST['description'] ?? '';
    $type = $_POST['type'];

    if (empty($title) || empty($startTime) || empty($examPeriod)) {
        throw new Exception("ข้อมูลไม่ครบ");
    }

    // เริ่ม transaction
    $conn->begin_transaction();

    // เพิ่มข้อมูลชุดข้อสอบ
    $stmt = $conn->prepare("INSERT INTO question_sets (title, type, start_time, exam_period, description, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $type, $startTime, $examPeriod, $description]);
    $questionSetId = $conn->insert_id;

    // วนลูปเพิ่มคำถาม
    foreach ($_POST['questions'] as $qIndex => $question) {
        $text = $question['text'] ?? '';
        $correctIndex = $question['correct'] ?? null;
        $choices = $question['choices'] ?? [];

        if (empty($text) || $correctIndex === null || !isset($choices[$correctIndex])) {
            throw new Exception("คำถามข้อที่ " . ($qIndex + 1) . " ไม่สมบูรณ์");
        }

        // เพิ่มคำถาม
        $stmt = $conn->prepare("INSERT INTO questions (question_set_id, question_text) VALUES (?, ?)");
        $stmt->execute([$questionSetId, $text]);
        $questionId = $conn->insert_id;

        // เพิ่มตัวเลือก
        foreach ($choices as $cIndex => $choiceText) {
            $isCorrect = ($cIndex == $correctIndex) ? 1 : 0;
            $stmt = $conn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, ?, ?)");
            $stmt->execute([$questionId, $choiceText, $isCorrect]);
        }
    }

    $conn->commit();
    log_action("Create examination success.");
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $conn->rollBack();
    log_action("Create examination Failed: " . $e->getMessage());
    log_error($e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
