<?php
// Persist a student's answers for one exam, in a single transaction.
// Relies on user_answers UNIQUE (user_id, exam_id, question_id).
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'db_error']);
    exit();
}

require_login_json();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['exam_id']) || !isset($data['answers']) || !is_array($data['answers'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'nodata']);
    exit();
}

$user_id = (int) ($_SESSION['user']['id'] ?? 0);
$exam_id = (int) $data['exam_id'];
$answers = $data['answers'];

if ($user_id <= 0 || $exam_id <= 0) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'nologin']);
    exit();
}

// Already submitted? (has an answer row for every question in the set)
$dupStmt = $conn->prepare(
    "SELECT (SELECT COUNT(*) FROM questions WHERE question_set_id = ?) AS q_total,
            (SELECT COUNT(*) FROM user_answers WHERE user_id = ? AND exam_id = ?) AS a_total"
);
$dupStmt->bind_param("iii", $exam_id, $user_id, $exam_id);
$dupStmt->execute();
$counts = $dupStmt->get_result()->fetch_assoc();
$dupStmt->close();

if ((int) $counts['q_total'] > 0 && (int) $counts['a_total'] >= (int) $counts['q_total']) {
    echo json_encode(['status' => 'duplicate', 'message' => 'duplicatesend']);
    exit();
}

$conn->begin_transaction();
try {
    $stmt = $conn->prepare(
        "INSERT INTO user_answers (user_id, exam_id, question_id, choice_id, answered_at)
         VALUES (?, ?, ?, ?, NOW())
         ON DUPLICATE KEY UPDATE choice_id = VALUES(choice_id), answered_at = NOW()"
    );
    foreach ($answers as $ans) {
        $question_id = (int) ($ans['question_id'] ?? 0);
        if ($question_id <= 0) {
            continue;
        }
        $choice_id = isset($ans['choice_id']) && $ans['choice_id'] !== null ? (int) $ans['choice_id'] : null;
        $stmt->bind_param("iiii", $user_id, $exam_id, $question_id, $choice_id);
        $stmt->execute();
    }
    $stmt->close();
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'success']);
} catch (Throwable $e) {
    $conn->rollback();
    log_error("exam_answers failed: " . $e->getMessage(), 'exam');
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'error']);
}

$conn->close();
