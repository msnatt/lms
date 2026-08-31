<?php
// Roster for the SMS (course_student) and AMS (course_access) pages.
// Admin-only. Returns every user plus an is_enrolled flag for the given course.
// Never returns password / email / phone (unlike Fetch_user.php).
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_admin_json();

// table + user column come from a fixed whitelist, never from input
$MAP = [
    'student' => ['table' => 'course_student', 'user_col' => 'owner_id'],
    'access'  => ['table' => 'course_access',  'user_col' => 'user_id'],
];
$typeKey = $_GET['type'] ?? 'student';
$t = $MAP[$typeKey] ?? $MAP['student'];

$course_id = isset($_GET['course_id']) && $_GET['course_id'] !== '' ? (int) $_GET['course_id'] : 0;

$sql = "SELECT u.id, u.code, u.name, u.is_admin,
               (x.id IS NOT NULL) AS is_enrolled
        FROM user u
        LEFT JOIN {$t['table']} x
               ON x.{$t['user_col']} = u.id AND x.course_id = ? AND x.is_deleted = 0
        WHERE u.is_deleted = 0
        ORDER BY u.code";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = [
        'id'          => $row['id'],
        'code'        => $row['code'],
        'name'        => $row['name'],
        'is_admin'    => $row['is_admin'],
        'is_enrolled' => (int) $row['is_enrolled'],
    ];
}

header('Content-Type: application/json');
echo json_encode($rows, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
