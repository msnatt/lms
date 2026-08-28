<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";
header("Content-Type: application/json");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'กรุณาเข้าสู่ระบบก่อนใช้งาน']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'method_not_allowed']);
    exit();
}

// อ่าน user_id จาก session เท่านั้น — เดิมรับจาก $_POST ทำให้ลงทะเบียนแทนคนอื่นได้
$user_id = (int)$_SESSION['user_id'];
$course_id = (int)($_POST['course_id'] ?? 0);

if (!$course_id) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบคอร์สนี้', 'course_id' => $course_id]);
    exit();
}

try {
    $conn->begin_transaction();

    // ตรวจว่าคอร์สมีจริงและเผยแพร่แล้วก่อนอนุญาตลงทะเบียน
    $sql_course = "SELECT id FROM course WHERE id = ? AND is_deleted = 0 AND is_publish = 1";
    $stmt_course = $conn->prepare($sql_course);
    $stmt_course->bind_param("i", $course_id);
    $stmt_course->execute();
    if (!$stmt_course->get_result()->fetch_assoc()) {
        throw new Exception('ไม่พบคอร์สนี้ หรือคอร์สยังไม่เผยแพร่');
    }
    $stmt_course->close();

    // กันลงทะเบียนซ้ำ — เช็คก่อนว่ามีแถวเดิมอยู่แล้วหรือไม่ (คืนสถานะถ้าเคยถอนไปก่อน)
    // เดิม endpoint นี้ INSERT ตรงๆ ไม่เช็คก่อนเลย กดปุ่มซ้ำ/ยิงซ้ำได้แถวซ้ำไม่จำกัด
    $sql_check = "SELECT id, is_deleted FROM course_student WHERE course_id = ? AND owner_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $course_id, $user_id);
    $stmt_check->execute();
    $existing = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    if ($existing) {
        if ($existing['is_deleted'] == 1) {
            $sql_restore = "UPDATE course_student SET is_deleted = 0, update_date = NOW() WHERE id = ?";
            $stmt_restore = $conn->prepare($sql_restore);
            $stmt_restore->bind_param("i", $existing['id']);
            $stmt_restore->execute();
            $stmt_restore->close();
        }
        // ถ้าลงทะเบียนอยู่แล้ว (is_deleted = 0) ไม่ต้องทำอะไรเพิ่ม — ถือว่าสำเร็จ (idempotent)
    } else {
        $sql_insert = "INSERT INTO course_student (course_id, owner_id) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $course_id, $user_id);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    // เตรียมแถว course_points สำหรับทุก content ชนิดข้อสอบ (type_id = 7) ของคอร์สนี้
    // เดิมพึ่ง $_POST['data'] ที่ client ส่งมาเอง (กำหนด unitid/exam_id เองได้ทั้งหมด) — ตอนนี้
    // query จาก DB ตรงๆ แทน ไม่เชื่อค่าที่ client ส่งมาอีกต่อไป
    $sql_quiz = "SELECT unit.id AS unit_id, content.content AS content
                 FROM content
                 JOIN unit ON unit.id = content.unit_id
                 WHERE unit.course_id = ? AND content.type_id = 7
                   AND unit.is_deleted = 0 AND content.is_deleted = 0";
    $stmt_quiz = $conn->prepare($sql_quiz);
    $stmt_quiz->bind_param("i", $course_id);
    $stmt_quiz->execute();
    $quizRows = $stmt_quiz->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt_quiz->close();

    $sql_check_point = "SELECT id FROM course_points WHERE user_id = ? AND course_id = ? AND unit_id = ? AND exam_id = ?";
    $stmt_check_point = $conn->prepare($sql_check_point);
    $sql_point = "INSERT INTO course_points (user_id, course_id, unit_id, exam_id, point, total) VALUES (?, ?, ?, ?, 0, 0)";
    $stmt_point = $conn->prepare($sql_point);

    foreach ($quizRows as $quiz) {
        $parts = explode('_', $quiz['content'], 2);
        $exam_id = (int)($parts[0] ?? 0);
        if (!$exam_id) {
            continue;
        }
        $unit_id = (int)$quiz['unit_id'];

        $stmt_check_point->bind_param("iiii", $user_id, $course_id, $unit_id, $exam_id);
        $stmt_check_point->execute();
        if (!$stmt_check_point->get_result()->fetch_assoc()) {
            $stmt_point->bind_param("iiii", $user_id, $course_id, $unit_id, $exam_id);
            $stmt_point->execute();
        }
    }

    $conn->commit();
    log_action("ลงทะเบียนเรียนคอร์ส id={$course_id}", "student_management");

    echo json_encode([
        'status' => 'success',
        'message' => 'save data successful.',
        'course_id' => $course_id
    ]);
} catch (Throwable $e) {
    $conn->rollback();
    log_error("ลงทะเบียนเรียนไม่สำเร็จ course_id={$course_id}: " . $e->getMessage(), "student_management");
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    $conn->close();
}
