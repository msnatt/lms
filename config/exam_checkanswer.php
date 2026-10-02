<?php
// Grade a student's submitted answers for one exam.
// SECURITY: grading is done entirely from the DB. The request body is only
// trusted for the exam id — never for which choice is "correct".
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['total' => 0, 'correct' => 0, 'score_percent' => 0]);
    exit();
}

require_login_json();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['total' => 0, 'correct' => 0, 'score_percent' => 0]);
    exit();
}

$input   = json_decode(file_get_contents('php://input'), true) ?: [];
$user_id = (int) ($_SESSION['user']['id'] ?? 0);

// The old client still posts {correct_data: <exam object>}; we only read its id.
$exam_id = 0;
if (isset($input['exam_id'])) {
    $exam_id = (int) $input['exam_id'];
} elseif (isset($input['correct_data']['id'])) {
    $exam_id = (int) $input['correct_data']['id'];
}

if ($user_id <= 0 || $exam_id <= 0) {
    echo json_encode(['total' => 0, 'correct' => 0, 'score_percent' => 0]);
    exit();
}

// Correct answers straight from the DB.
$correct_answers = [];   // question_id => correct choice_id
$caStmt = $conn->prepare(
    "SELECT c.question_id, c.id AS choice_id
     FROM choices c
     JOIN questions q ON q.id = c.question_id
     WHERE q.question_set_id = ? AND c.is_correct = 1"
);
$caStmt->bind_param("i", $exam_id);
$caStmt->execute();
$res = $caStmt->get_result();
while ($row = $res->fetch_assoc()) {
    $correct_answers[(int) $row['question_id']] = (int) $row['choice_id'];
}
$caStmt->close();

$total = count($correct_answers);

// The student's stored answers for THIS exam.
$correct = 0;
if ($total > 0) {
    $uaStmt = $conn->prepare(
        "SELECT question_id, choice_id FROM user_answers WHERE user_id = ? AND exam_id = ?"
    );
    $uaStmt->bind_param("ii", $user_id, $exam_id);
    $uaStmt->execute();
    $res = $uaStmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $qid = (int) $row['question_id'];
        if (isset($correct_answers[$qid]) && (int) $row['choice_id'] === $correct_answers[$qid]) {
            $correct++;
        }
    }
    $uaStmt->close();
}

echo json_encode([
    'total'         => $total,
    'correct'       => $correct,
    'score_percent' => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
]);

$conn->close();
