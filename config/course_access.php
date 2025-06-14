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
        $course_id = $_POST['course_id'];
        $users = $_POST['users'];

        // $url = "http://localhost/lms/config/Find_Course.php?courseid=" . $course_id;
        // $response = file_get_contents($url);
        // $course = json_decode($response, true); // แปลง JSON เป็น array

        // แปลงสตริงเป็น array ด้วย comma ( , )
        $names = explode(',', $users);

        // วนลูปแสดงชื่อทีละคน
        foreach ($names as $name) {
            $stmt = $conn->prepare("SELECT id FROM user WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id); // ผูกตัวแปรเพื่อรับค่า
            if ($stmt->fetch()) {

                $stmt_check = $conn->prepare("SELECT id FROM course_access WHERE course_id = ? AND user_id = ?");
                $stmt_check->bind_param("ii", $course_id, $id);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows == 0) {
                    $sql_course = "INSERT INTO course_access (course_id, user_id) VALUES (?, ?)";
                    $stmt_insert = $conn->prepare($sql_course);
                    if (!$stmt_insert) {
                        die("Error preparing course statement: " . $conn->error);
                    }
                    $stmt_insert->bind_param("ii", $course_id, $id);
                    // Execute คำสั่ง SQL
                    if (!$stmt_insert->execute()) {
                        echo json_encode([
                            'success' => false,
                            'message' => $stmt_insert->error
                        ]);
                    }
                }
            } else {
                // ส่งข้อมูล JSON กลับไปยังฝั่ง JavaScript
                echo json_encode([
                    'success' => false,
                    'message' => 'Sorry!, Not found some name please check again.',
                ]);
            }
        }

        // Commit การทำธุรกรรม
        $conn->commit();

        // ส่งข้อมูล JSON กลับไปยังฝั่ง JavaScript
        echo json_encode([
            'success' => true,
            'message' => 'All users have been authorized.',
            'course_id' => $course_id
        ]);
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการทำธุรกรรม
        $conn->rollback();

        // ส่งข้อมูล JSON เกี่ยวกับข้อผิดพลาด
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    } finally {
        // ปิดการเชื่อมต่อ
        $conn->close();
    }
}
