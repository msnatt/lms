<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['courseid'] ?? null;

    // เฉพาะ admin หรือเจ้าของคอร์สเท่านั้นถึงดูรายชื่อสมาชิกแบบละเอียดได้
    // เดิม endpoint นี้ไม่เช็คสิทธิ์เลย ใครก็ตามที่ login (หรือแม้ไม่ login) ก็ดึงรายชื่อ
    // พร้อมอีเมล/เบอร์โทร/username ของสมาชิกทุกคนในคอร์สไหนก็ได้
    $user = $_SESSION['user'] ?? [];
    $isAdmin = !empty($user['is_admin']);
    $isOwner = false;
    if (!$isAdmin && $course_id) {
        $sql_owner = "SELECT create_by FROM course WHERE id = ?";
        if ($stmt_owner = $conn->prepare($sql_owner)) {
            $stmt_owner->bind_param("i", $course_id);
            $stmt_owner->execute();
            $courseRow = $stmt_owner->get_result()->fetch_assoc();
            $stmt_owner->close();
            $isOwner = $courseRow && (int)$courseRow['create_by'] === (int)($user['id'] ?? 0);
        }
    }
    if (!$isAdmin && !$isOwner) {
        http_response_code(403);
        echo json_encode(['error' => 'forbidden']);
        exit;
    }

    // ตัดคอลัมน์ PII ที่ไม่จำเป็นสำหรับตารางสมาชิก (email/username/rank) ออกจาก SELECT
    // เหลือเฉพาะข้อมูลที่หน้าตารางสมาชิกต้องแสดงจริง
    $sql = "SELECT course_student.id,
                   course_student.course_id,
                   course_student.owner_id,
                   course_student.create_date,
                   course_student.update_date,
                   course_student.is_deleted,

                   user.id AS user_id,
                   user.code AS user_code,
                   user.name AS user_name,
                   user.is_admin AS user_is_admin,
                   user.is_deleted AS user_is_deleted
            FROM course_student
            LEFT JOIN user ON course_student.owner_id = user.id
            WHERE course_student.is_deleted = 0 AND user.is_deleted = 0 AND course_student.course_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [
        "course_id" => $course_id,
        "users" => []
    ];

    while ($row = $result->fetch_assoc()) {
        // ✅ ตรวจสอบว่า user นี้มีอยู่แล้วหรือยัง
        $userExists = array_filter($data["users"], function ($c) use ($row) {
            return $c["user_id"] == $row["user_id"];
        });

        if (!$userExists) {
            $data["users"][] = [
                "user_id" => $row["user_id"],
                "code" => $row["user_code"],
                "name" => $row["user_name"],
                "is_admin" => $row["user_is_admin"],
                "is_deleted" => $row["user_is_deleted"]
            ];
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


    $stmt->close();
}

$conn->close();
