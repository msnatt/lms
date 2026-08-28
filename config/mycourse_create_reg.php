<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method_not_allowed"]);
    exit;
}

$course_id = intval($_POST['course_id'] ?? 0);
$usersInput = $_POST['users'] ?? [];
if (!is_array($usersInput)) {
    $usersInput = [$usersInput];
}
$userIds = array_values(array_unique(array_filter(array_map('intval', $usersInput))));

if (!$course_id) {
    echo json_encode(["success" => false, "message" => "nocourse"]);
    exit;
}

$registered = 0;
$removed = 0;

try {
    $conn->begin_transaction();

    // ลงทะเบียน/คืนสถานะให้ทุกคนที่ถูกติ๊ก
    foreach ($userIds as $ownerId) {
        $stmt_check = $conn->prepare("SELECT id, is_deleted FROM course_student WHERE course_id = ? AND owner_id = ?");
        $stmt_check->bind_param("ii", $course_id, $ownerId);
        $stmt_check->execute();
        $existing = $stmt_check->get_result()->fetch_assoc();

        if ($existing) {
            if ($existing['is_deleted'] == 1) {
                $stmt_update = $conn->prepare("UPDATE course_student SET is_deleted = 0, update_date = NOW() WHERE id = ?");
                $stmt_update->bind_param("i", $existing['id']);
                $stmt_update->execute();
                $registered++;
            }
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO course_student (course_id, owner_id) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $course_id, $ownerId);
            $stmt_insert->execute();
            $registered++;
        }
    }

    // ถอนทะเบียนคนที่ไม่ได้อยู่ในชุดที่ติ๊กแล้ว (soft delete)
    // จำกัดขอบเขตการถอนทะเบียนเฉพาะ "นักเรียน" (is_admin = 0) เท่านั้น
    // เพราะหน้าปิ๊กเกอร์แสดงเฉพาะนักเรียน แอดมินที่มีแถวอยู่ก่อนแล้วต้องไม่ถูกแตะ
    if (!empty($userIds)) {
        $placeholders = implode(',', array_fill(0, count($userIds), '?'));
        $types = 'i' . str_repeat('i', count($userIds));
        $sql_remove = "SELECT cs.id FROM course_student cs
                        JOIN user u ON u.id = cs.owner_id
                        WHERE cs.course_id = ? AND cs.is_deleted = 0 AND u.is_admin = 0 AND cs.owner_id NOT IN ($placeholders)";
        $stmt_remove = $conn->prepare($sql_remove);
        $stmt_remove->bind_param($types, $course_id, ...$userIds);
    } else {
        $stmt_remove = $conn->prepare("SELECT cs.id FROM course_student cs
                        JOIN user u ON u.id = cs.owner_id
                        WHERE cs.course_id = ? AND cs.is_deleted = 0 AND u.is_admin = 0");
        $stmt_remove->bind_param("i", $course_id);
    }
    $stmt_remove->execute();
    $toRemove = $stmt_remove->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($toRemove as $row) {
        $stmt_del = $conn->prepare("UPDATE course_student SET is_deleted = 1, update_date = NOW() WHERE id = ?");
        $stmt_del->bind_param("i", $row['id']);
        $stmt_del->execute();
        $removed++;
    }

    $conn->commit();
    log_action("อัปเดตการลงทะเบียนคอร์ส id={$course_id}: ลง {$registered}, ถอน {$removed}", "student_management");

    echo json_encode([
        "success" => true,
        "message" => "regsaved",
        "registered" => $registered,
        "removed" => $removed,
        "course_id" => $course_id
    ]);
} catch (Throwable $e) {
    $conn->rollback();
    log_error("บันทึกการลงทะเบียนคอร์สไม่สำเร็จ: " . $e->getMessage(), "student_management");
    echo json_encode(["success" => false, "message" => "savefailed"]);
} finally {
    $conn->close();
}
