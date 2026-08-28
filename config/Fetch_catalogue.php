<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ทุกคนที่ล็อกอินแล้วเข้าดูสารบัญคอร์สได้ (ไม่ใช่หน้า admin-only)
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

$isAdmin = !empty($_SESSION['user']['is_admin']);

// นักเรียนเห็นเฉพาะคอร์สที่เผยแพร่แล้ว ส่วน admin เห็นทุกสถานะ (รวมฉบับร่าง)
$publishFilter = $isAdmin ? "" : " AND c.is_publish = 1";

$sql = "SELECT f.id AS faculty_id, f.name AS faculty_name,
               d.id AS department_id, d.name AS department_name,
               c.id AS course_id, c.code AS course_code, c.name AS course_name,
               c.description AS course_description, c.image_code AS course_image_code,
               c.is_publish AS course_is_publish
        FROM course c
        LEFT JOIN faculty    f ON f.id = c.faculty_id    AND f.is_deleted = 0
        LEFT JOIN department d ON d.id = c.department_id AND d.is_deleted = 0
        WHERE c.is_deleted = 0" . $publishFilter . "
        ORDER BY f.name, d.name, c.code";

$result = $conn->query($sql);

// รหัสคณะ/สาขาที่ถือว่า "ยังไม่ระบุ" — id=0 คือ placeholder "please select",
// id=1 คือ placeholder "all faculty"/"All" ในตาราง faculty/department, และ NULL คือ
// กรณี LEFT JOIN ไม่เจอแถวจริง (faculty_id/department_id ชี้ไปยัง id ที่ไม่มีอยู่หรือถูกลบ)
function isUnassignedId($id) {
    return $id === null || (int)$id === 0 || (int)$id === 1;
}

$faculties = []; // key => data, เก็บลำดับการพบเจอไว้ด้วย

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $facUnassigned = isUnassignedId($row['faculty_id']);
        $facKey = $facUnassigned ? '__unassigned__' : $row['faculty_id'];

        if (!isset($faculties[$facKey])) {
            $faculties[$facKey] = [
                'faculty_id' => $facUnassigned ? null : (int)$row['faculty_id'],
                'faculty_name' => $facUnassigned ? null : $row['faculty_name'],
                'is_unassigned' => $facUnassigned,
                'departments' => [],
            ];
        }

        $depUnassigned = isUnassignedId($row['department_id']);
        $depKey = $depUnassigned ? '__unassigned__' : $row['department_id'];

        if (!isset($faculties[$facKey]['departments'][$depKey])) {
            $faculties[$facKey]['departments'][$depKey] = [
                'department_id' => $depUnassigned ? null : (int)$row['department_id'],
                'department_name' => $depUnassigned ? null : $row['department_name'],
                'is_unassigned' => $depUnassigned,
                'courses' => [],
            ];
        }

        $faculties[$facKey]['departments'][$depKey]['courses'][] = [
            'course_id' => (int)$row['course_id'],
            'course_code' => $row['course_code'],
            'course_name' => $row['course_name'],
            'description' => $row['course_description'],
            'image_code' => $row['course_image_code'],
            'is_publish' => (int)$row['course_is_publish'],
        ];
    }
}

// แปลง associative map เป็น array เรียงลำดับ พร้อมนับจำนวนคอร์สต่อคณะ
$output = [];
foreach ($faculties as $fac) {
    $courseCount = 0;
    $departments = array_values($fac['departments']);
    foreach ($departments as $dep) {
        $courseCount += count($dep['courses']);
    }
    $fac['departments'] = $departments;
    $fac['course_count'] = $courseCount;
    $output[] = $fac;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);

$conn->close();
?>
