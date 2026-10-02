<?php
// Soft-delete a question set. Admin-only.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "db_error"]);
    exit();
}

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method_not_allowed"]);
    exit();
}

$exam_id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : 0;
if ($exam_id <= 0) {
    echo json_encode(["success" => false, "message" => "incomplete"]);
    exit();
}

$conn->begin_transaction();
try {
    $check = $conn->prepare("SELECT id FROM question_sets WHERE id = ? AND is_deleted = 0");
    $check->bind_param("i", $exam_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        $conn->rollback();
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "not_found"]);
        exit();
    }
    $check->close();

    $upd = $conn->prepare("UPDATE question_sets SET is_deleted = 1 WHERE id = ?");
    $upd->bind_param("i", $exam_id);
    $upd->execute();
    $upd->close();

    $conn->commit();
    log_action("delete exam #$exam_id", 'ems');
    echo json_encode(["success" => true]);
} catch (Throwable $e) {
    $conn->rollback();
    log_error("exam_deleted failed: " . $e->getMessage(), 'ems');
    echo json_encode(["success" => false, "message" => "error"]);
}

$conn->close();
