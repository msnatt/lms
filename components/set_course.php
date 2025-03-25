<?php
session_start();
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['courseid'] ?? null;

    $sql = "SELECT * FROM course WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // ดึงข้อมูลจากฐานข้อมูล
        $course = $result->fetch_assoc(); // ดึงแค่แถวเดียว

        // ปิด statement
        $stmt->close();
    }

    // เซ็ตค่า course ลงใน session
    $_SESSION['course'] = $course;

    $sql_user = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql_user);

    if ($stmt) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("i", $course['create_by']);
        $stmt->execute();
        $result = $stmt->get_result();

        // ดึงข้อมูลจากฐานข้อมูล
        $owner = $result->fetch_assoc(); // ดึงแค่แถวเดียว

        // ปิด statement
        $stmt->close();
    }
    $conn->close();

    // เซ็ตค่า owner ลงใน session
    $_SESSION['owner'] = $owner;

    // เปลี่ยนเส้นทางไปยัง detail.php
    header("Location: ../pages/detail.php?courseid=" . $course_id);
    exit();
}
