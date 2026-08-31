<?php
// List of non-deleted question sets. Consumed by:
//   - include/scriptjs-quiz-management.html  (admin EMS table)
//   - include/scriptjs-course_create.html    (content-type "Examination/Quiz" dropdown)
//   - include/scriptjs-edit_course.html      (same dropdown)
// The two course-builder pages are NOT admin-only (checkLogin only), so this
// endpoint stays login-gated, not admin-gated. Shape must remain a flat array
// with id/title/type/start_time/exam_period/created_at.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_login_json();

$sql = "SELECT qs.id, qs.title, qs.type, qs.description, qs.start_time,
               qs.exam_period, qs.created_at, qs.is_deleted,
               (SELECT COUNT(*) FROM questions WHERE question_set_id = qs.id) AS question_count
        FROM question_sets qs
        WHERE qs.is_deleted = 0
        ORDER BY qs.created_at DESC";
$result = $conn->query($sql);

$options = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options, JSON_UNESCAPED_UNICODE);

$conn->close();
