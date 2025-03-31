<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลจากตาราง categories
$sql = "SELECT  faculty.id AS faculty_id,
                faculty.name AS faculty_name,
                faculty.is_deleted AS faculty_is_deleted,

                course.id AS course_id, 
                course.code AS course_code, 
                course.image_code AS course_image_code, 
                course.name AS course_name, 
                course.description AS course_description, 
                course.objective AS course_objective, 
                course.faculty_id AS course_faculty_id, 
                course.department_id AS course_department_id, 
                course.create_date AS course_create_date, 
                course.update_date AS course_update_date, 
                course.create_by AS course_create_by, 
                course.update_by AS course_update_by, 
                course.is_publish AS course_is_publish,
                course.is_deleted AS course_is_deleted

            FROM faculty
            LEFT JOIN course ON faculty.id = course.faculty_id
            WHERE course.is_deleted = 0 AND faculty.is_deleted = 0";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {

    // ✅ สร้างโครงสร้างหลักหากยังไม่มีข้อมูลใน `$data`
    if (!isset($data[$row['faculty_name']])) {
        $data[$row['faculty_name']] = [
            "id" => $row["faculty_id"],
            "name" => $row["faculty_name"],
            "courses" => [],
        ];
    }

    // ✅ ตรวจสอบว่า `courses` มีข้อมูลนี้อยู่แล้วหรือยัง
    $courseExists = array_filter($data[$row['faculty_name']]["courses"], function ($c) use ($row) {
        return $c["course_id"] == $row["course_id"];
    });

    if (!$courseExists) {
        $data[$row['faculty_name']]["courses"][] = [
            "course_id" => $row["course_id"],
            "course_code" => $row["course_code"],
            "image_code" => $row["course_image_code"],
            "course_name" => $row["course_name"],
            "description" => $row["course_description"],
            "objective" => $row["course_objective"],
            "faculty_id" => $row["course_faculty_id"],
            "department_id" => $row["course_department_id"],
            "create_date" => $row["course_create_date"],
            "update_date" => $row["course_update_date"],
            "create_by" => $row["course_create_by"],
            "update_by" => $row["course_update_by"],
            "is_publish" => $row["course_is_publish"],
            "is_deleted" => $row["course_is_deleted"]
        ];
    }
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


$stmt->close();
