<?php
session_start();
include '../config/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ต้อง login ก่อนถึงดูรายละเอียดคอร์ส (รวม unit/content ทั้งหมด) ได้
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['course_id'] ?? null;

    // เงื่อนไข is_deleted ของ unit/content ต้องอยู่ใน ON ไม่ใช่ WHERE — ถ้าอยู่ WHERE
    // จะทำให้ LEFT JOIN กลายเป็น INNER JOIN โดยปริยาย (แถวที่ join ไม่เจอ = NULL จะไม่ผ่าน `= 0`)
    // ผลคือคอร์สที่ยังไม่มี unit เลย หรือ unit ที่ยังไม่มี content เลย จะหายไปทั้งก้อนจาก response
    $sql = "SELECT course.id AS course_id,
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

                   unit.id AS unit_id,
                   unit.course_id AS unit_course_id,
                   unit.name AS unit_name,
                   unit.introduction AS unit_introduction,
                   unit.conclusion AS unit_conclusion,
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
            LEFT JOIN unit ON course.id = unit.course_id AND unit.is_deleted = 0
            LEFT JOIN content ON unit.id = content.unit_id AND content.is_deleted = 0
            WHERE course.is_deleted = 0 AND course.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        if (!isset($data["course"])) {
            $data['course'] = [
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
                "is_deleted" => $row["course_is_deleted"],
                "units" => []

            ];
        }

        // ไม่มี unit จริง (คอร์สยังไม่มี unit เลย) — LEFT JOIN ให้ NULL มา ข้ามไปไม่ต้อง push
        if ($row["unit_id"] === null) {
            continue;
        }

        // ✅ ตรวจสอบว่า `units` มีข้อมูลนี้อยู่แล้วหรือยัง
        $unitExists = array_filter($data["course"]["units"], function ($u) use ($row) {
            return $u["unit_id"] == $row["unit_id"];
        });

        if (!$unitExists) {
            $data["course"]["units"][] = [
                "unit_id" => $row["unit_id"],
                "unit_name" => $row["unit_name"],
                "unit_course_id" => $row["unit_course_id"],
                "unit_introduction" => $row["unit_introduction"],
                "unit_conclusion" => $row["unit_conclusion"],
                "create_date" => $row["unit_create_date"],
                "update_date" => $row["unit_update_date"],
                "is_deleted" => $row["unit_is_deleted"],
                "contents" => []
            ];
        }

        // ไม่มี content จริง (unit นี้ยังไม่มี content เลย) — ข้ามไปไม่ต้อง push
        if ($row["content_id"] === null) {
            continue;
        }

        foreach ($data['course']['units'] as $key => $value) {
            if ($value["unit_id"] != $row["unit_id"]) {
                continue;
            }
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

    // ตรวจสิทธิ์เห็นเนื้อหา: admin, เจ้าของคอร์ส, หรือลงทะเบียนเรียนแล้ว (course_student)
    // เดิม endpoint นี้ไม่เช็คเลย — และ detail.php ก็เคยดึงเนื้อหาทุกคอร์สทั้งระบบผ่าน
    // Fetch_Unit.php/Fetch_content.php (ลบไปแล้ว) โดยไม่เช็คอะไรเลยเช่นกัน
    if (isset($data['course'])) {
        $user = $_SESSION['user'] ?? [];
        $isAdmin = !empty($user['is_admin']);
        $isOwner = isset($user['id']) && (int)$data['course']['create_by'] === (int)$user['id'];

        $canSeeContent = $isAdmin || $isOwner;
        if (!$canSeeContent) {
            $sql_enrolled = "SELECT id FROM course_student WHERE course_id = ? AND owner_id = ? AND is_deleted = 0";
            if ($stmt_enrolled = $conn->prepare($sql_enrolled)) {
                $uid = (int)($user['id'] ?? 0);
                $stmt_enrolled->bind_param("ii", $course_id, $uid);
                $stmt_enrolled->execute();
                $canSeeContent = $stmt_enrolled->get_result()->fetch_assoc() !== null;
                $stmt_enrolled->close();
            }
        }

        if (!$canSeeContent) {
            $data['course']['units'] = [];
            $data['course']['locked'] = true;
        } else {
            $data['course']['locked'] = false;
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


    $stmt->close();
}

$conn->close();
