<?php
// Record a student's exam score into course_points.
// SECURITY: the score is re-computed from the DB here; the posted
// correct/total/score_percent values are ignored. Replay is blocked.
// Relies on course_points UNIQUE (user_id, course_id, unit_id, exam_id).
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'DB Connect failed']);
    exit();
}

require_login_json();

try {
    $user_id   = (int) ($_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? 0);
    $course_id = (int) ($_POST['course_id'] ?? 0);
    $unit_id   = (int) ($_POST['unit_id'] ?? 0);
    $exam_id   = (int) ($_POST['exam_id'] ?? 0);

    if ($user_id <= 0) {
        throw new Exception('ไม่พบข้อมูลผู้ใช้งาน');
    }
    if ($course_id <= 0 || $unit_id <= 0 || $exam_id <= 0) {
        throw new Exception('ข้อมูลไม่ครบถ้วน');
    }

    // Replay guard: a non-zero score for this exam is already stored.
    $chk = $conn->prepare(
        "SELECT total FROM course_points
         WHERE user_id = ? AND course_id = ? AND unit_id = ? AND exam_id = ?"
    );
    $chk->bind_param("iiii", $user_id, $course_id, $unit_id, $exam_id);
    $chk->execute();
    $existing = $chk->get_result()->fetch_assoc();
    $chk->close();
    if ($existing && (int) $existing['total'] > 0) {
        echo json_encode(['status' => 'duplicate', 'message' => 'duplicatesend']);
        exit();
    }

    // Re-grade from the DB.
    $correct_answers = [];
    $caStmt = $conn->prepare(
        "SELECT c.question_id, c.id AS choice_id
         FROM choices c JOIN questions q ON q.id = c.question_id
         WHERE q.question_set_id = ? AND c.is_correct = 1"
    );
    $caStmt->bind_param("i", $exam_id);
    $caStmt->execute();
    $r = $caStmt->get_result();
    while ($row = $r->fetch_assoc()) {
        $correct_answers[(int) $row['question_id']] = (int) $row['choice_id'];
    }
    $caStmt->close();

    $total   = count($correct_answers);
    $correct = 0;
    if ($total > 0) {
        $uaStmt = $conn->prepare(
            "SELECT question_id, choice_id FROM user_answers WHERE user_id = ? AND exam_id = ?"
        );
        $uaStmt->bind_param("ii", $user_id, $exam_id);
        $uaStmt->execute();
        $r = $uaStmt->get_result();
        while ($row = $r->fetch_assoc()) {
            $qid = (int) $row['question_id'];
            if (isset($correct_answers[$qid]) && (int) $row['choice_id'] === $correct_answers[$qid]) {
                $correct++;
            }
        }
        $uaStmt->close();
    }

    $up = $conn->prepare(
        "INSERT INTO course_points (user_id, course_id, unit_id, exam_id, point, total)
         VALUES (?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE point = VALUES(point), total = VALUES(total)"
    );
    $up->bind_param("iiiiii", $user_id, $course_id, $unit_id, $exam_id, $correct, $total);
    if (!$up->execute()) {
        throw new Exception("เกิดข้อผิดพลาดในการบันทึกคะแนน: " . $up->error);
    }
    $up->close();

    echo json_encode(['status' => 'success', 'message' => 'sendcom']);
} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
