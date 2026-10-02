<?php
// Slim student list for the certificate page. Returns only id/code/name (no
// password hash / email like Fetch_user.php). Admin-only. Optional ?course_id=N
// filters to students enrolled in that course.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_admin_json();

$course_id = isset($_GET['course_id']) && $_GET['course_id'] !== '' ? (int) $_GET['course_id'] : null;

if ($course_id) {
    $sql = "SELECT user.id, user.code, user.name
            FROM course_student
            LEFT JOIN user ON course_student.owner_id = user.id
            WHERE course_student.is_deleted = 0
              AND user.is_deleted = 0
              AND course_student.course_id = ?
            GROUP BY user.id, user.code, user.name
            ORDER BY user.code";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, code, name FROM user WHERE is_deleted = 0 ORDER BY code";
    $result = $conn->query($sql);
}

$students = [];
while ($row = $result->fetch_assoc()) {
    if ($row['id'] === null) {
        continue;
    }
    $students[] = [
        'id'   => $row['id'],
        'code' => $row['code'],
        'name' => $row['name'],
    ];
}

header('Content-Type: application/json');
echo json_encode($students, JSON_UNESCAPED_UNICODE);

if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
