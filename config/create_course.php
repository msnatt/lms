<?php
session_start();

// รวมไฟล์เชื่อมต่อฐานข้อมูล
include "../config/no-crash.php";
include "../config/connect.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับข้อมูล JSON จาก FormData
    $namecourse = $_POST['name_course'];
    $description = $_POST['textBoxDescription'];
    $objective = $_POST['textBoxObjective'];
    $data = json_decode($_POST['data'], true);


    // // ตรวจสอบค่าที่ต้องใช้ในการสร้าง course
    // if (!$name || !$description) {
    //     echo "Missing required fields.";
    //     exit();
    // }

    // // เตรียมคำสั่ง SQL
    // $sql = "INSERT INTO courses (name, description, content, username) VALUES (?, ?, ?, ?)";

    // $stmt = $conn->prepare($sql);
    // if ($stmt) {
    //     $stmt->bind_param("ssss", $name, $description, $content, $username);

    //     if ($stmt->execute()) {
    //         echo "Course created successfully!";
    //     } else {
    //         echo "Error: " . $stmt->error;
    //     }

    //     $stmt->close();
    // } else {
    //     echo "Error preparing statement: " . $conn->error;
    // }
}

$conn->close();
exit();
?>
