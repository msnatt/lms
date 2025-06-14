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
        $slide01 = $_POST['slide01'];
        $slide02 = $_POST['slide02'];
        $slide03 = $_POST['slide03'];
        $icon01 = $_POST['icon01'];
        $icon02 = $_POST['icon02'];
        $icon03 = $_POST['icon03'];
        $icon04 = $_POST['icon04'];
        $icon05 = $_POST['icon05'];
        $icon06 = $_POST['icon06'];
        $icon07 = $_POST['icon07'];
        $icon08 = $_POST['icon08'];
        $icon09 = $_POST['icon09'];
        $youtube_id = $_POST['youtube_id'];

        // ตรวจสอบว่ามีหรือไม่
        $sql = "UPDATE home_profile SET slide01 = ?, slide02 = ?, slide03 = ?, icon01 = ?, icon02 = ?, icon03 = ?, icon04 = ?, icon05 = ?, icon06 = ?, icon07 = ?, icon08 = ?,icon09 = ?, youtube_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssss", $slide01, $slide02, $slide03, $icon01, $icon02, $icon03, $icon04, $icon05, $icon06, $icon07, $icon08, $icon09, $youtube_id);
        $stmt->execute();
        $stmt->store_result();

        $stmt->close();
        $conn->commit();
        echo '<script>window.location.href = "../pages/home.php";</script>';
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ยกเลิกการบันทึกทั้งหมด
        $conn->rollback();
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}

$conn->close();
exit();
