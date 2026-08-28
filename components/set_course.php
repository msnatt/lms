<?php
include '../components/session.php';
checkLogin();
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['courseid'] ?? null;

    $sql = "SELECT * FROM course WHERE id = ? AND is_deleted = 0";
    $stmt = $conn->prepare($sql);

    $course = null;
    if ($stmt) {
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $course = $result->fetch_assoc();

        $stmt->close();
    }

    if (!$course) {
        // ไม่พบคอร์ส (ถูกลบ/ไม่มีจริง) — กลับไปหน้ารายการคอร์สแทนที่จะเซ็ต session ว่างแล้วพังต่อที่ detail.php
        $conn->close();
        header("Location: ../pages/course.php");
        exit();
    }

    $_SESSION['course'] = $course;

    $owner = null;
    $sql_user = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql_user);

    if ($stmt) {
        $stmt->bind_param("i", $course['create_by']);
        $stmt->execute();
        $result = $stmt->get_result();

        $owner = $result->fetch_assoc();

        $stmt->close();
    }
    $conn->close();

    $_SESSION['owner'] = $owner;

    // เปลี่ยนเส้นทางไปยัง detail.php
    header("Location: ../pages/detail.php?courseid=" . $course_id);
    exit();
}
