<?php
// Create a question set + its questions + choices. Admin-only.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'db_error']);
    exit();
}

require_admin_json();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'method_not_allowed']);
    exit();
}

$ALLOWED_TYPES = ['pre-test', 'post-test', 'quiz'];

$title       = trim($_POST['title'] ?? '');
$type        = $_POST['type'] ?? '';
$startTime   = trim($_POST['startTime'] ?? '');
$examPeriod  = $_POST['examPeriod'] ?? '';
$description = trim($_POST['description'] ?? '');
$questions   = $_POST['questions'] ?? null;

if ($title === '' || $startTime === '' || $examPeriod === '' || $description === '') {
    echo json_encode(['success' => false, 'message' => 'incomplete']);
    exit();
}
if (mb_strlen($title) > 255) {
    echo json_encode(['success' => false, 'message' => 'too_long']);
    exit();
}
if (!in_array($type, $ALLOWED_TYPES, true)) {
    echo json_encode(['success' => false, 'message' => 'bad_type']);
    exit();
}
$ts = strtotime($startTime);
if ($ts === false) {
    echo json_encode(['success' => false, 'message' => 'bad_date']);
    exit();
}
$startTimeSql = date('Y-m-d H:i:s', $ts);

$examPeriod = (int) $examPeriod;
if ($examPeriod < 1 || $examPeriod > 1440) {
    echo json_encode(['success' => false, 'message' => 'bad_period']);
    exit();
}

if (!is_array($questions) || count($questions) < 1) {
    echo json_encode(['success' => false, 'message' => 'no_question']);
    exit();
}

// Normalise + validate every question before touching the DB.
$clean = [];
foreach ($questions as $q) {
    $qtext   = trim($q['text'] ?? '');
    $choices = $q['choices'] ?? null;
    $correct = $q['correct'] ?? null;

    if ($qtext === '' || !is_array($choices)) {
        echo json_encode(['success' => false, 'message' => 'bad_question']);
        exit();
    }
    $choices = array_values(array_filter(array_map(fn($c) => trim((string) $c), $choices), fn($c) => $c !== ''));
    if (count($choices) < 2) {
        echo json_encode(['success' => false, 'message' => 'bad_question']);
        exit();
    }
    if (!is_numeric($correct) || !isset($choices[(int) $correct])) {
        echo json_encode(['success' => false, 'message' => 'bad_question']);
        exit();
    }
    $clean[] = ['text' => $qtext, 'choices' => $choices, 'correct' => (int) $correct];
}

$conn->begin_transaction();
try {
    $setStmt = $conn->prepare(
        "INSERT INTO question_sets (title, type, start_time, exam_period, description, created_at)
         VALUES (?, ?, ?, ?, ?, NOW())"
    );
    $setStmt->bind_param("sssis", $title, $type, $startTimeSql, $examPeriod, $description);
    $setStmt->execute();
    $setId = $conn->insert_id;
    $setStmt->close();

    $qStmt = $conn->prepare("INSERT INTO questions (question_set_id, question_text) VALUES (?, ?)");
    $cStmt = $conn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, ?, ?)");

    foreach ($clean as $q) {
        $qStmt->bind_param("is", $setId, $q['text']);
        $qStmt->execute();
        $qId = $conn->insert_id;

        foreach ($q['choices'] as $i => $choiceText) {
            $isCorrect = ($i === $q['correct']) ? 1 : 0;
            $cStmt->bind_param("isi", $qId, $choiceText, $isCorrect);
            $cStmt->execute();
        }
    }
    $qStmt->close();
    $cStmt->close();

    $conn->commit();
    log_action("create exam #$setId ($type): " . count($clean) . " question(s)", 'ems');
    echo json_encode(['success' => true, 'id' => $setId]);
} catch (Throwable $e) {
    $conn->rollback();
    log_error("exam_create failed: " . $e->getMessage(), 'ems');
    echo json_encode(['success' => false, 'message' => 'error']);
}

$conn->close();
