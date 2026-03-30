<?php
session_start();
include '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $course_id = $_GET['courseid'] ?? null;

    $sql = "SELECT * FROM course WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $course = $result->fetch_assoc();

        $stmt->close();
    }

    $_SESSION['course'] = $course;

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
    header("Location: ../pages/course_detail.php?courseid=" . $course_id);
    // header("Location: ../pages/detail.php?courseid=" . $course_id);
    exit();
}
