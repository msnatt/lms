<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['course_id'] ?? null;

    $sql = "SELECT course.id AS course_id, 
                   course.code AS course_code, 
                   course.image_code AS course_image_code, 
                   course.name AS course_name, 
                   course.description AS course_description, 
                   course.objective AS course_objective, 
                   course.create_date AS course_create_date, 
                   course.update_date AS course_update_date, 
                   course.create_by AS course_create_by, 
                   course.update_by AS course_update_by, 
                   course.is_deleted AS course_is_deleted,

                   unit.id AS unit_id, 
                   unit.course_id AS unit_course_id,
                   unit.name AS unit_name,                    
                   unit.create_date AS unit_create_date, 
                   unit.update_date AS unit_update_date, 
                   unit.is_deleted AS unit_is_deleted, 

                   content.id AS content_id, 
                   content.unit_id AS content_unit_id, 
                   content.type_id AS content_type_id, 
                   content.content AS content_content, 
                   content.create_date AS content_create_date, 
                   content.update_date AS content_update_date, 
                   content.is_deleted AS content_is_deleted

            FROM course
            LEFT JOIN unit ON course.id = unit.course_id
            LEFT JOIN content ON unit.id = content.unit_id
            WHERE course.is_deleted = 0 AND course.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // if(!isset($data["course"])){$data['course'] = [];}

        // $courseExists = array_filter($data["course"], function ($u) use ($row) {
        //     return $u["course_id"] == $row["course_id"];
        // });

        if (!isset($data["course"])) {
            $data['course'] = [
                "course_id" => $row["course_id"],
                "course_code" => $row["course_code"],
                "image_code" => $row["course_image_code"],
                "course_name" => $row["course_name"],
                "description" => $row["course_description"],
                "objective" => $row["course_objective"],
                "create_date" => $row["course_create_date"],
                "update_date" => $row["course_update_date"],
                "create_by" => $row["course_create_by"],
                "update_by" => $row["course_update_by"],
                "is_deleted" => $row["course_is_deleted"],
                "units" => []

            ];
        }

        // ✅ ตรวจสอบว่า `units` มีข้อมูลนี้อยู่แล้วหรือยัง
        $unitExists = array_filter($data["course"]["units"], function ($u) use ($row) {
            return $u["unit_id"] == $row["unit_id"];
        });

        if (!$unitExists) {
            $data["course"]["units"][] = [
                "unit_id" => $row["unit_id"],
                "unit_course_id" => $row["unit_course_id"],
                "unit_name" => $row["unit_name"],
                "create_date" => $row["unit_create_date"],
                "update_date" => $row["unit_update_date"],
                "is_deleted" => $row["unit_is_deleted"],
                "contents" => []
            ];
        }
        foreach ($data['course']['units'] as $key => $value) {
            # code...
            // ✅ ตรวจสอบว่า `contents` มีข้อมูลนี้อยู่แล้วหรือยัง
            $contentExists = array_filter($data["course"]["units"][$key]["contents"], function ($c) use ($row) {
                return $c["content_id"] == $row["content_id"];
            });

            if (!$contentExists) {
                $data["course"]["units"][$key]["contents"][] = [
                    "content_id" => $row["content_id"],
                    "unit_id" => $row["content_unit_id"],
                    "type_id" => $row["content_type_id"],
                    "content" => $row["content_content"],
                    "create_date" => $row["content_create_date"],
                    "update_date" => $row["content_update_date"],
                    "is_deleted" => $row["content_is_deleted"]
                ];
            }
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


    $stmt->close();
}

$conn->close();
