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
            // Do this here
        }
        // Commit การทำธุรกรรม
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
