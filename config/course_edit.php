<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username'];
$user = $_SESSION['user'] ?? 'N/A';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // เปิด Transaction
    $conn->begin_transaction();

    try {
        // รับค่าจากฟอร์ม
        $course_id = $_POST['course_id'];
        $name = $_POST['name_course'];
        $code = $_POST['code_course'];
        $img = $_POST['image_code'];
        $description = $_POST['textBoxDescription'];
        $objective = $_POST['textBoxObjective'];
        $id_schedule = $_POST["id_schedule"] ?? [];
        $is_publish = $_POST["is_publish"] == "on" ? 1 : 0;
        $select_day = $_POST["select_day"] ?? [];
        $select_start = $_POST["select_start"] ?? [];
        $select_end = $_POST["select_end"] ?? [];
        $is_deleted_schedule = $_POST["schedule_is_deleted"] ?? [];
        $is_deleted = (int)$_POST['is_deleted'];
        $units = json_decode($_POST['data'], true);

        // ตรวจสอบว่ามี course_id นี้หรือไม่
        $sql_check_course = "SELECT id FROM course WHERE id = ?";
        $stmt = $conn->prepare($sql_check_course);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // อัปเดตข้อมูล course
            $sql_update_course = "UPDATE course SET code = ?, name = ?, image_code = ?, description = ?, objective = ?, update_by = ?,is_publish = ?, is_deleted = ? WHERE id = ? ";
            $stmt = $conn->prepare($sql_update_course);
            $stmt->bind_param("sssssiiii", $code, $name, $img,  $description, $objective, $user['id'], $is_publish, $is_deleted, $course_id);
            $stmt->execute();
        } else {
            die("Error: Course ID not found.");
        }

        // ตรวจสอบว่ามี course_schedule นี้หรือไม่
        $sql_check_schedule = "SELECT * FROM course_schedule WHERE course_id = ?";
        $stmt_schedule = $conn->prepare($sql_check_schedule);
        $stmt_schedule->bind_param("i", $course_id);
        $stmt_schedule->execute();
        $stmt_schedule->store_result();

        if ($stmt_schedule->num_rows > 0) {
            for ($i = 0; $i < count($select_day); $i++) {
                $id = $id_schedule[$i];
                $day_id = $select_day[$i];
                $start_time = $select_start[$i];
                $end_time = $select_end[$i];
                $is_deleted_schedule = $is_deleted_schedule[$i];

                // อัปเดตข้อมูล course
                $sql_update_course = "UPDATE course_schedule SET course_id = ?, day_id = ?, start_time = ?, end_time = ?, is_deleted = ? WHERE id = ? ";
                $stmt_schedule = $conn->prepare($sql_update_course);
                $stmt_schedule->bind_param("iissii", $course_id, $day_id, $start_time, $end_time, $is_deleted_schedule, $id);
                $stmt_schedule->execute();
            }
        }
        $stmt_schedule->close();

        $newUnit_id = 0;
        $tempFolder = "../temp/$username/";
        $uploadFolder = "../uploads/$username/";
        // อัปเดตหรือเพิ่ม unit และ content
        foreach ($units as $unit) {
            if ($unit['type'] == 'header') {
                // ตรวจสอบว่า unit มีอยู่แล้วหรือไม่
                $sql_check_unit = "SELECT id FROM unit WHERE course_id = ? AND id = ?";
                $stmt = $conn->prepare($sql_check_unit);
                $stmt->bind_param("ii", $course_id, $unit['id']);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // อัปเดต unit
                    $sql_update_unit = "UPDATE unit SET name = ?, is_deleted = ? WHERE id = ? ";
                    $stmt = $conn->prepare($sql_update_unit);
                    $stmt->bind_param("sii", $unit['content'], $unit['is_deleted'], $unit['id']);
                    $stmt->execute();
                    $newUnit_id = $unit['id'];
                } else {
                    // เพิ่ม unit ใหม่
                    $sql_insert_unit = "INSERT INTO unit (course_id, name) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql_insert_unit);
                    $stmt->bind_param("is", $course_id, $unit['content']);
                    $stmt->execute();
                    $newUnit_id = $conn->insert_id;
                }
            } else if ($unit['type'] == 'content') {
                // ตรวจสอบว่า content มีอยู่แล้วหรือไม่
                $sql_check_content = "SELECT id FROM content WHERE id = ?";
                $stmt = $conn->prepare($sql_check_content);
                $stmt->bind_param("i", $unit['id']);
                $stmt->execute();
                $stmt->store_result();
                // เช็คว่าเป็นประเภท "content" และ selecttype เป็น 2, 3, หรือ 4
                if (in_array($unit['selecttype'], [2, 3, 4, 6])) {
                    $oldPath = $unit['content']; // ไฟล์ต้นทาง
                    $filename = basename($oldPath); // ดึงเฉพาะชื่อไฟล์
                    $newPath = $uploadFolder . $filename; // กำหนดปลายทางใหม่

                    // ตรวจสอบว่าไฟล์อยู่ใน temp folder และย้ายไฟล์
                    if (file_exists($tempFolder . $filename)) {
                        if (rename($tempFolder . $filename, $newPath)) {
                            $unit['content'] = $newPath; // อัปเดตพาธใหม่ใน array
                        } else {
                            echo "เกิดข้อผิดพลาดในการย้ายไฟล์: $filename <br>";
                        }
                    }
                }

                if ($unit['selecttype'] == 7) {
                    // ดึงนักเรียนทั้งหมดในคอร์สนี้
                    $sql_mycourse = "SELECT owner_id FROM course_student WHERE course_id = ?";
                    $stmt_myc = $conn->prepare($sql_mycourse);
                    $stmt_myc->bind_param("i", $course_id);
                    $stmt_myc->execute();
                    $result = $stmt_myc->get_result();  // ✅ ใช้กับ $stmt_myc

                    list($id_exam, $name) = explode("_", $unit['content']);

                    if ($result->num_rows > 0) {
                        // เตรียม SQL สำหรับตรวจสอบซ้ำ
                        $sql_check = "SELECT id FROM course_points 
                                      WHERE user_id = ? AND course_id = ? AND unit_id = ? AND exam_id = ?";
                        $stmt_check = $conn->prepare($sql_check);

                        // เตรียม SQL สำหรับ insert
                        $sql_point = "INSERT INTO course_points (user_id, course_id, unit_id, exam_id, point, total)
                                      VALUES (?, ?, ?, ?, 0, 0)";
                        $stmt_insert = $conn->prepare($sql_point);

                        while ($row = $result->fetch_assoc()) {
                            $owner_id = $row['owner_id'];

                            // ตรวจสอบว่าข้อมูลซ้ำหรือไม่
                            $stmt_check->bind_param("iiii", $owner_id, $course_id, $newUnit_id, $id_exam);
                            $stmt_check->execute();
                            $check_result = $stmt_check->get_result();

                            if ($check_result->num_rows == 0) {
                                // ถ้ายังไม่มีข้อมูลซ้ำ → insert ได้
                                $stmt_insert->bind_param("iiii", $owner_id, $course_id, $newUnit_id, $id_exam);
                                $stmt_insert->execute();
                            }
                        }
                    }
                }
                if ($stmt->num_rows > 0) {
                    // อัปเดต content
                    $sql_update_content = "UPDATE content SET type_id = ?, content = ?, is_deleted = ? WHERE id = ? ";
                    $stmt = $conn->prepare($sql_update_content);
                    $stmt->bind_param("isii", $unit['selecttype'], $unit['content'], $unit['is_deleted'], $unit['id']);
                    $stmt->execute();
                } else {
                    // เพิ่ม content ใหม่
                    $sql_insert_content = "INSERT INTO content (unit_id, type_id, content) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql_insert_content);
                    $stmt->bind_param("iss", $newUnit_id, $unit['selecttype'], $unit['content']);
                    $stmt->execute();
                }
            }
        }

        // ถ้าทุกอย่างสำเร็จ ให้ commit
        $conn->commit();
        echo "บันทึกข้อมูลเรียบร้อย";
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}

$conn->close();
exit();
