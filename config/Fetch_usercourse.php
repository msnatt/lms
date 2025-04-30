<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['courseid'] ?? null;

    $sql = "SELECT course_student.id, 
                   course_student.course_id, 
                   course_student.owner_id, 
                   course_student.create_date, 
                   course_student.update_date, 
                   course_student.is_active, 
                   course_student.is_deleted,

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
            LEFT JOIN user ON course_student.owner_id = user.id
            WHERE course_student.is_deleted = 0 AND user.is_deleted = 0 AND course_student.course_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // ✅ สร้างโครงสร้างหลักหากยังไม่มีข้อมูลใน `$data`
        if (empty($data)) {
            $data = [
                "course_id" => $row["course_id"],
                "create_date" => $row["create_date"],
                "update_date" => $row["update_date"],
                "users" => []
            ];
        }

        // ✅ ตรวจสอบว่า `courses` มีข้อมูลนี้อยู่แล้วหรือยัง
        $userExists = array_filter($data["users"], function ($c) use ($row) {
            return $c["user_id"] == $row["user_id"];
        });

        if (!$userExists) {
            $data["users"][] = [
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
