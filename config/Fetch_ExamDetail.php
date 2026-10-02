<?php
// Full question + choice tree for ONE exam set, including the is_correct flag.
// Admin-only — this is the ONE endpoint allowed to expose the answer key.
// The student-facing config/Fetch_questionAll.php must NEVER include is_correct.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_admin_json();

header('Content-Type: application/json');

$exam_id = isset($_GET['exam_id']) && $_GET['exam_id'] !== '' ? (int) $_GET['exam_id'] : 0;
if ($exam_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'bad_id']);
    exit();
}

$setStmt = $conn->prepare(
    "SELECT id, title, type, description, start_time, exam_period, created_at
     FROM question_sets WHERE id = ? AND is_deleted = 0"
);
$setStmt->bind_param("i", $exam_id);
$setStmt->execute();
$set = $setStmt->get_result()->fetch_assoc();
$setStmt->close();

if (!$set) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'not_found']);
    exit();
}

$sql = "SELECT q.id  AS q_id,  q.question_text AS q_text, q.question_type AS q_type,
               c.id  AS c_id,  c.choice_text   AS c_text, c.is_correct    AS c_correct
        FROM questions q
        LEFT JOIN choices c ON c.question_id = q.id
        WHERE q.question_set_id = ?
        ORDER BY q.id, c.id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];      // q_id => index into $out['questions']
$out = [
    'success'     => true,
    'id'          => (int) $set['id'],
    'title'       => $set['title'],
    'type'        => $set['type'],
    'description' => $set['description'],
    'start_time'  => $set['start_time'],
    'exam_period' => $set['exam_period'],
    'created_at'  => $set['created_at'],
    'questions'   => [],
];

while ($row = $result->fetch_assoc()) {
    $qid = (int) $row['q_id'];
    if (!isset($questions[$qid])) {
        $questions[$qid] = count($out['questions']);
        $out['questions'][] = [
            'id'      => $qid,
            'text'    => $row['q_text'],
            'type'    => $row['q_type'],
            'choices' => [],
        ];
    }
    if ($row['c_id'] !== null) {
        $out['questions'][$questions[$qid]]['choices'][] = [
            'id'         => (int) $row['c_id'],
            'text'       => $row['c_text'],
            'is_correct' => (int) $row['c_correct'],
        ];
    }
}

echo json_encode($out, JSON_UNESCAPED_UNICODE);
$stmt->close();
$conn->close();
