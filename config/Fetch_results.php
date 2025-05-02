<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "SELECT course_points.id,
                   course_points.user_id,
                   course_points.course_id,
                   course_points.unit_id,
                   course_points.exam_id,
                   course_points.point,
                   course_points.total,

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

                   question_sets.id AS question_sets_id,
                   question_sets.title AS question_sets_title,
                   question_sets.type AS question_sets_type,
                   question_sets.description AS question_sets_description,
                   question_sets.start_time AS question_sets_start_time,
                   question_sets.exam_period AS question_sets_exam_period,
                   question_sets.created_at AS question_sets_created_at,
                   question_sets.is_deleted AS question_sets_is_deleted,
                   
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

            FROM course_points
            LEFT JOIN course ON course_points.course_id = course.id
            LEFT JOIN question_sets ON course_points.exam_id = question_sets.id
            LEFT JOIN user ON course_points.user_id = user.id
            WHERE course.is_deleted = 0  AND question_sets.is_deleted = 0 AND course_points.user_id = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $re = $stmt->get_result();

    $data = null;
    $courses = [];

    while ($row = $re->fetch_assoc()) {
        if (!$data) {
            // สร้าง user object ครั้งเดียว
            $data = [
                'id' => $row['user_id'],
                'code' => $row['user_code'],
                'name' => $row['user_name'],
                'username' => $row['user_username'],
                'email' => $row['user_email'],
                'rank' => $row['user_rank'],
                'telephone' => $row['user_telephone'],
                'create_date' => $row['user_create_date'],
                'update_date' => $row['user_update_date'],
                'is_pushhandup' => $row['user_is_pushhandup'],
                'is_admin' => $row['user_is_admin'],
                'is_deleted' => $row['user_is_deleted'],
                'courses' => []
            ];
        }

        $course_id = $row['course_id'];
        if (!isset($courses[$course_id])) {
            $courses[$course_id] = [
                'id' => $row['course_id'],
                'code' => $row['course_code'],
                'image_code' => $row['course_image_code'],
                'name' => $row['course_name'],
                'description' => $row['course_description'],
                'objective' => $row['course_objective'],
                'faculty_id' => $row['course_faculty_id'],
                'department_id' => $row['course_department_id'],
                'create_date' => $row['course_create_date'],
                'update_date' => $row['course_update_date'],
                'create_by' => $row['course_create_by'],
                'update_by' => $row['course_update_by'],
                'is_publish' => $row['course_is_publish'],
                'is_deleted' => $row['course_is_deleted'],
                'questions' => []
            ];
        }

        $courses[$course_id]['questions'][] = [
            'id' => $row['question_sets_id'],
            'title' => $row['question_sets_title'],
            'type' => $row['question_sets_type'],
            'description' => $row['question_sets_description'],
            'start_time' => $row['question_sets_start_time'],
            'exam_period' => $row['question_sets_exam_period'],
            'created_at' => $row['question_sets_created_at'],
            'is_deleted' => $row['question_sets_is_deleted'],
            'unit_id' => $row['unit_id'],
            'point' => $row['point'],
            'total' => $row['total']
        ];
    }

    $data['courses'] = array_values($courses); // ลบ key จาก associative array
    echo json_encode($data);


    $stmt->close();
}

$conn->close();
