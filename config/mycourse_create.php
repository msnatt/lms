<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";
header("Content-Type: application/json");

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

    try {
        // เริ่มต้น transaction
        $conn->begin_transaction();
        // รับค่าจากฟอร์ม
        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];
        $data = json_decode($_POST['data'], true);

        // บันทึกข้อมูลลงในตาราง course
        $sql_course = "INSERT INTO course_student (course_id, owner_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_course);
        if (!$stmt) {
            die("Error preparing course statement: " . $conn->error);
        }
        // Bind ข้อมูลที่ต้องการใส่ใน SQL statement
        $stmt->bind_param("ii", $course_id, $user_id);
        // Execute คำสั่ง SQL
        if (!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
        } else {
            foreach ($data as $rowh) {
                foreach ($rowh as $row) {
                    if ($row['type'] == "7") {
                        list($id, $name) = explode('_', $row['content']);

                        $sql_point = "INSERT INTO course_points (user_id, course_id, unit_id, exam_id, point, total) VALUE (?, ?, ?, ?, 0, 0)";
                        $stmt_point = $conn->prepare($sql_point);
                        $stmt_point->bind_param("iiii", $user_id, $course_id, $row['unitid'], $id);
                        if (!$stmt_point->execute()) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => "can't insert course_points",
                                'course_id' => $course_id
                            ]);
                        };
                    }
                }
            }
        }
        $conn->commit();

        // ส่งข้อมูล JSON กลับไปยังฝั่ง JavaScript
        echo json_encode([
            'status' => 'success',
            'message' => 'save data successful.',
            'course_id' => $course_id
        ]);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการทำธุรกรรม
        $conn->rollback();

        // ส่งข้อมูล JSON เกี่ยวกับข้อผิดพลาด
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    } finally {
        // ปิดการเชื่อมต่อ
        $conn->close();
    }
}
