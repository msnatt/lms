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
        $name = $_POST['name_course'];
        $code = $_POST['code_course'];
        $description = $_POST['textBoxDescription'];
        $objective = $_POST['textBoxObjective'];
        $units = json_decode($_POST['data'], true);

        // บันทึกข้อมูลลงในตาราง course
        $sql_course = "INSERT INTO course (code, image_code, name, description, objective, create_by) VALUES (?, 1, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_course);
        if (!$stmt) {
            die("Error preparing course statement: " . $conn->error);
        }
        $stmt->bind_param("sssss", $code, $name, $description, $objective, $user['id']);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
        // $stmt->execute();

        // ดึงค่า id ที่เพิ่งถูก insert
        $course_id = $conn->insert_id;
        echo "Course ID: " . $course_id . "<br>";

        $unit_id = 0;
        $tempFolder = "../temp/$username/";
        $uploadFolder = "../uploads/$username/";

        foreach ($units as $unit) {
            if ($unit['type'] == 'header') {
                // บันทึกข้อมูลลงในตาราง unit
                $sql_unit = "INSERT INTO unit (course_id, name) VALUES (?, ?)";
                $stmt = $conn->prepare($sql_unit);

                $stmt->bind_param("is", $course_id, $unit['content']);
                $stmt->execute();
                $unit_id = $conn->insert_id;
                print("Unit id : " . $unit_id);
            } else if ($unit['type'] == 'content') {
                // เช็คว่าเป็นประเภท "content" และ selecttype เป็น 2, 3, หรือ 4
                if (in_array($unit['selecttype'], [2, 3, 4])) {
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
                // บันทึกข้อมูลลงในตาราง content
                if ($unit_id != 0) {
                    $sql_content = "INSERT INTO content (unit_id, type_id, content) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql_content);

                    $stmt->bind_param("iss", $unit_id, $unit['selecttype'], $unit['content']);
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
