<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เปิดให้ผู้ใช้ที่ล็อกอินทุกคน (chat ใช้กับผู้ใช้ทั่วไป) แต่ไม่เปิดโล่ง
require_login_json();

// รายชื่อคอลัมน์ชัดเจน — ไม่ส่ง password ออก
$sql = "SELECT id, code, name, email, username, rank, telephone,
               create_date, update_date, is_pushhandup, is_admin, is_deleted
        FROM user
        WHERE is_deleted = 0
        ORDER BY code";
$result = $conn->query($sql);

$options = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

// ส่งข้อมูลกลับในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($options, JSON_UNESCAPED_UNICODE);

// ปิดการเชื่อมต่อ
$conn->close();
