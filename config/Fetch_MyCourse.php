<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['user_id'] ?? null;

    $sql = "SELECT course_student.id, 
                   course_student.course_id, 
                   course_student.owner_id, 
                   course_student.create_date, 
                   course_student.update_date, 
                   course_student.is_active, 
                   course_student.is_deleted,

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
                   course.is_deleted AS course_is_deleted,
                   
                   user.id AS user_id, 
                   user.code AS user_code, 
                   user.name AS user_name, 
                   user.username AS user_username, 
                   user.email AS user_email, 
                   user.rank AS user_rank, 
                   user.telephone AS user_telephone, 
                   user.create_date AS user_create_date, 
                   user.update_date AS user_update_date, 
                   user.is_pushhandup AS user_is_pushhandup, 
                   user.is_admin AS user_is_admin, 
                   user.is_deleted AS user_is_deleted
            FROM course_student
            LEFT JOIN course ON course_student.course_id = course.id
            LEFT JOIN user ON course_student.owner_id = user.id
            WHERE course_student.is_deleted = 0 AND course.is_deleted = 0  AND course_student.owner_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // ✅ สร้างโครงสร้างหลักหากยังไม่มีข้อมูลใน `$data`
        if (empty($data)) {
            $data = [
                "create_date" => $row["create_date"],
                "update_date" => $row["update_date"],
                "courses" => [],
                "owner" => null
            ];
        }

        // ✅ ตรวจสอบว่า `courses` มีข้อมูลนี้อยู่แล้วหรือยัง
        $courseExists = array_filter($data["courses"], function ($c) use ($row) {
            return $c["course_id"] == $row["course_id"];
        });

        if (!$courseExists) {
            $data["courses"][] = [
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

        // ✅ กำหนดค่า `owner` ถ้ายังไม่มี
        if (!$data["owner"]) {
            $data["owner"] = [
                "user_id" => $row["user_id"],
                "code" => $row["user_code"],
                "name" => $row["user_name"],
                "username" => $row["user_username"],
                "email" => $row["user_email"],
                "rank" => $row["user_rank"],
                "telephone" => $row["user_telephone"],
                "create_date" => $row["user_create_date"],
                "update_date" => $row["user_update_date"],
                "is_pushhandup" => $row["user_is_pushhandup"],
                "is_admin" => $row["user_is_admin"],
                "is_deleted" => $row["user_is_deleted"]
            ];
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


    $stmt->close();
}

$conn->close();
