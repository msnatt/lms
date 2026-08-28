<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";

header('Content-Type: application/json');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'กรุณาเข้าสู่ระบบก่อนใช้งาน']);
    exit();
}

$username = $_SESSION['username'];
$user = $_SESSION['user'] ?? 'N/A';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = (int)($_POST['course_id'] ?? 0);

    // ตรวจสิทธิ์: ต้องเป็น admin หรือเจ้าของคอร์ส (create_by) เท่านั้นถึงแก้ไข/ลบคอร์สนี้ได้
    // เดิมเช็คแค่ isset($_SESSION['username']) — ผู้ใช้ที่ login อยู่คนไหนก็แก้/ลบคอร์สใครก็ได้
    $sql_owner = "SELECT create_by FROM course WHERE id = ?";
    $stmt_owner = $conn->prepare($sql_owner);
    $stmt_owner->bind_param("i", $course_id);
    $stmt_owner->execute();
    $owner_result = $stmt_owner->get_result();
    $course_row = $owner_result->fetch_assoc();
    $stmt_owner->close();

    if (!$course_row) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบคอร์สนี้']);
        exit();
    }

    $isAdmin = !empty($user['is_admin']);
    $isOwner = (int)$course_row['create_by'] === (int)$user['id'];
    if (!$isAdmin && !$isOwner) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์แก้ไขคอร์สนี้']);
        exit();
    }

    // เปิด Transaction
    $conn->begin_transaction();

    try {
        // รับค่าจากฟอร์ม
        $name = $_POST['name_course'];
        $code = $_POST['code_course'];
        $img = $_POST['image_code'];
        $description = $_POST['textBoxDescription'];
        $objective = $_POST['textBoxObjective'];
        $id_schedule = $_POST["id_schedule"] ?? [];
        $is_publish = (($_POST["is_publish"] ?? '') === "on") ? 1 : 0;
        $faculty_id = (int)($_POST['select_faculty'] ?? 0);
        $department_id = (int)($_POST['select_department'] ?? 0);
        $select_day = $_POST["select_day"] ?? [];
        $select_start = $_POST["select_start"] ?? [];
        $select_end = $_POST["select_end"] ?? [];
        $is_deleted_schedule_list = $_POST["schedule_is_deleted"] ?? [];
        $is_deleted = (int)$_POST['is_deleted'];
        $units = json_decode($_POST['data'], true);

        // อัปเดตข้อมูล course (เพิ่ม faculty_id/department_id ที่เดิมไม่เคยบันทึกเลย)
        $sql_update_course = "UPDATE course SET code = ?, name = ?, image_code = ?, description = ?, objective = ?, faculty_id = ?, department_id = ?, update_by = ?, is_publish = ?, is_deleted = ? WHERE id = ? ";
        $stmt = $conn->prepare($sql_update_course);
        $stmt->bind_param(
            "sssssiiiiii",
            $code,
            $name,
            $img,
            $description,
            $objective,
            $faculty_id,
            $department_id,
            $user['id'],
            $is_publish,
            $is_deleted,
            $course_id
        );
        $stmt->execute();

        // เดิมทั้ง loop นี้ถูกครอบด้วย if ($stmt_schedule->num_rows > 0) ทำให้คอร์สที่ยังไม่เคยมี
        // ตารางเรียนมาก่อนเลย (0 แถวเดิม) บันทึกตารางเรียนแถวใหม่ไม่ได้เลยแม้แต่แถวเดียว —
        // ตรวจสอบ insert/update เป็นรายแถวอยู่แล้วข้างในลูป จึงไม่จำเป็นต้องมี gate นี้ครอบอีกชั้น
        for ($i = 0; $i < count($select_day); $i++) {
            $schedule_id = $id_schedule[$i] ?? null;
            $day_id = $select_day[$i];
            $start_time = $select_start[$i];
            $end_time = $select_end[$i];
            // เดิมตัวแปรนี้ชื่อซ้ำกับ array ด้านนอก ($is_deleted_schedule = $is_deleted_schedule[$i])
            // ทำให้รอบที่ 2 เป็นต้นไปอ่านค่าผิดเพี้ยนหมด (string offset แทน array index)
            $rowIsDeleted = $is_deleted_schedule_list[$i] ?? 0;

            $sql_check_schedule_each = "SELECT id FROM course_schedule WHERE id = ?";
            $stmt_schedule_each = $conn->prepare($sql_check_schedule_each);
            $stmt_schedule_each->bind_param("i", $schedule_id);
            $stmt_schedule_each->execute();
            $stmt_schedule_each->store_result();
            if ($schedule_id !== null && $stmt_schedule_each->num_rows > 0) {
                // อัปเดตข้อมูล course_schedule
                $sql_update_schedule = "UPDATE course_schedule SET course_id = ?, day_id = ?, start_time = ?, end_time = ?, is_deleted = ? WHERE id = ? ";
                $stmt_schedule_update = $conn->prepare($sql_update_schedule);
                $stmt_schedule_update->bind_param("iissii", $course_id, $day_id, $start_time, $end_time, $rowIsDeleted, $schedule_id);
                if (!$stmt_schedule_update->execute()) {
                    throw new Exception("Error executing schedule statement: " . $stmt_schedule_update->error);
                }
            } else {
                // ✅ บันทึกข้อมูลลงในตาราง course_schedule
                $sql_schedule = "INSERT INTO course_schedule (course_id, day_id, start_time, end_time) VALUES (?, ?, ?, ?)";
                $stmt_schedule_insert = $conn->prepare($sql_schedule);
                $stmt_schedule_insert->bind_param("iiss", $course_id, $day_id, $start_time, $end_time);
                if (!$stmt_schedule_insert->execute()) {
                    throw new Exception("Error executing schedule statement: " . $stmt_schedule_insert->error);
                }
            }
        }

        $newUnit_id = 0;
        $tempFolder = "../temp/$username/";
        $uploadFolder = "../uploads/$username/";
        // อัปเดตหรือเพิ่ม unit และ content
        foreach ($units as $unit) {
            if ($unit['type'] == 'header') {
                // รายการที่สร้างใหม่ระหว่างแก้ไข (flag is_new จาก frontend) ต้อง insert เสมอ
                // ไม่พึ่งการเช็คว่า id ชนกับของจริงในฐานข้อมูลเพียงอย่างเดียว (id ฝั่ง client เริ่มนับจาก
                // ตัวเลขน้อยๆ ซึ่งอาจชนกับ primary key จริงของ unit ที่เป็นของคอร์สอื่นได้)
                $isNew = !empty($unit['is_new']);

                $sql_check_unit = "SELECT id FROM unit WHERE course_id = ? AND id = ?";
                $stmt = $conn->prepare($sql_check_unit);
                $stmt->bind_param("ii", $course_id, $unit['id']);
                $stmt->execute();
                $stmt->store_result();

                if (!$isNew && $stmt->num_rows > 0) {
                    // อัปเดต unit (เพิ่ม introduction/conclusion ที่เดิมไม่เคยบันทึกเลย)
                    $sql_update_unit = "UPDATE unit SET name = ?, introduction = ?, conclusion = ?, is_deleted = ? WHERE id = ? AND course_id = ?";
                    $stmt = $conn->prepare($sql_update_unit);
                    $intro = $unit['intro'] ?? '';
                    $cons = $unit['cons'] ?? '';
                    $stmt->bind_param("sssiii", $unit['content'], $intro, $cons, $unit['is_deleted'], $unit['id'], $course_id);
                    $stmt->execute();
                    $newUnit_id = $unit['id'];
                } else {
                    // เพิ่ม unit ใหม่
                    $sql_insert_unit = "INSERT INTO unit (course_id, name, introduction, conclusion) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql_insert_unit);
                    $intro = $unit['intro'] ?? '';
                    $cons = $unit['cons'] ?? '';
                    $stmt->bind_param("isss", $course_id, $unit['content'], $intro, $cons);
                    $stmt->execute();
                    $newUnit_id = $conn->insert_id;
                }
            } else if ($unit['type'] == 'content') {
                $isNew = !empty($unit['is_new']);

                // ตรวจสอบว่า content มีอยู่แล้วหรือไม่ — scope ด้วย unit_id เสมอ (เดิมเช็คแค่ id เฉยๆ
                // ไม่ผูกกับ unit/course เลย ทำให้ id ชนกันข้ามคอร์สได้แล้วไป UPDATE ทับของคอร์สอื่น)
                $sql_check_content = "SELECT id FROM content WHERE id = ? AND unit_id = ?";
                $stmt = $conn->prepare($sql_check_content);
                $stmt->bind_param("ii", $unit['id'], $newUnit_id);
                $stmt->execute();
                $stmt->store_result();
                // เช็คว่าเป็นประเภท "content" และ selecttype เป็นไฟล์แนบ (2 รูป, 3 วิดีโอ, 4 PDF, 6 โมเดล 3 มิติ)
                if (in_array($unit['selecttype'], [2, 3, 4, 6])) {
                    $oldPath = $unit['content']; // ไฟล์ต้นทาง
                    $filename = basename($oldPath); // ดึงเฉพาะชื่อไฟล์
                    $newPath = $uploadFolder . $filename; // กำหนดปลายทางใหม่

                    // ตรวจสอบว่าไฟล์อยู่ใน temp folder และย้ายไฟล์
                    if (file_exists($tempFolder . $filename)) {
                        if (rename($tempFolder . $filename, $newPath)) {
                            $unit['content'] = $newPath; // อัปเดตพาธใหม่ใน array
                        } else {
                            throw new Exception("เกิดข้อผิดพลาดในการย้ายไฟล์: $filename");
                        }
                    }
                }

                if ($unit['selecttype'] == 7) {
                    // ดึงนักเรียนทั้งหมดในคอร์สนี้
                    $sql_mycourse = "SELECT owner_id FROM course_student WHERE course_id = ?";
                    $stmt_myc = $conn->prepare($sql_mycourse);
                    $stmt_myc->bind_param("i", $course_id);
                    $stmt_myc->execute();
                    $result = $stmt_myc->get_result();

                    list($id_exam, $quizName) = array_pad(explode("_", $unit['content'], 2), 2, null);

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
                if (!$isNew && $stmt->num_rows > 0) {
                    // อัปเดต content
                    $sql_update_content = "UPDATE content SET type_id = ?, content = ?, is_deleted = ? WHERE id = ? AND unit_id = ?";
                    $stmt = $conn->prepare($sql_update_content);
                    $stmt->bind_param("isiii", $unit['selecttype'], $unit['content'], $unit['is_deleted'], $unit['id'], $newUnit_id);
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
        echo json_encode(['status' => 'success', 'message' => 'บันทึกข้อมูลเรียบร้อย']);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
exit();
