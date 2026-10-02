<?php
// Enrol / un-enrol users into a course (SMS: course_student) or grant / revoke
// course access (AMS: course_access). Admin-only. Keyed by user id (never name).
// Replaces mycourse_create_reg.php + course_access.php.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'connection_failed']);
    exit();
}

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'method_not_allowed']);
    exit();
}

$MAP = [
    'student' => ['table' => 'course_student', 'user_col' => 'owner_id'],
    'access'  => ['table' => 'course_access',  'user_col' => 'user_id'],
];
$typeKey = $_POST['type'] ?? 'student';
if (!isset($MAP[$typeKey])) {
    echo json_encode(['success' => false, 'message' => 'bad_type']);
    exit();
}
$t = $MAP[$typeKey];

$action = $_POST['action'] ?? 'add';
if (!in_array($action, ['add', 'remove'], true)) {
    echo json_encode(['success' => false, 'message' => 'bad_action']);
    exit();
}

$course_id = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;
if ($course_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'no_course']);
    exit();
}

// course must exist
$c = $conn->prepare("SELECT id FROM course WHERE id = ? AND is_deleted = 0");
$c->bind_param("i", $course_id);
$c->execute();
$c->store_result();
if ($c->num_rows === 0) {
    $c->close();
    echo json_encode(['success' => false, 'message' => 'no_course']);
    exit();
}
$c->close();

$ids = json_decode($_POST['user_ids'] ?? '[]', true);
if (!is_array($ids)) {
    $ids = [];
}
$ids = array_values(array_unique(array_filter(array_map('intval', $ids), fn($v) => $v > 0)));
if (count($ids) === 0) {
    echo json_encode(['success' => false, 'message' => 'no_users']);
    exit();
}
if (count($ids) > 500) {
    echo json_encode(['success' => false, 'message' => 'too_many']);
    exit();
}

$adminId = (int) ($_SESSION['user']['id'] ?? 0);
$affected = 0;

$conn->begin_transaction();
try {
    if ($action === 'add') {
        if ($typeKey === 'student') {
            $stmt = $conn->prepare(
                "INSERT INTO course_student (course_id, owner_id) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE is_deleted = 0, update_date = NOW()"
            );
            foreach ($ids as $uid) {
                $stmt->bind_param("ii", $course_id, $uid);
                $stmt->execute();
                $affected += $stmt->affected_rows > 0 ? 1 : 0;
            }
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO course_access (course_id, user_id, is_access, create_by) VALUES (?, ?, 1, ?)
                 ON DUPLICATE KEY UPDATE is_deleted = 0, is_access = 1"
            );
            foreach ($ids as $uid) {
                $stmt->bind_param("iii", $course_id, $uid, $adminId);
                $stmt->execute();
                $affected += $stmt->affected_rows > 0 ? 1 : 0;
            }
        }
        $stmt->close();
    } else {
        $sql = "UPDATE {$t['table']} SET is_deleted = 1 WHERE course_id = ? AND {$t['user_col']} = ? AND is_deleted = 0";
        $stmt = $conn->prepare($sql);
        foreach ($ids as $uid) {
            $stmt->bind_param("ii", $course_id, $uid);
            $stmt->execute();
            $affected += $stmt->affected_rows;
        }
        $stmt->close();
    }

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    log_error('course_enroll failed: ' . $e->getMessage(), 'sms');
    echo json_encode(['success' => false, 'message' => 'db_error']);
    exit();
}

log_action("enroll $action ($typeKey): course $course_id, " . count($ids) . " user(s)", 'sms');

echo json_encode([
    'success'  => true,
    'action'   => $action,
    'affected' => $affected,
    'message'  => 'ok',
]);

$conn->close();
