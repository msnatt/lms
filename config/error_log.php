<?php
// เชื่อมต่อฐานข้อมูล
include_once '../config/connect.php'; // แก้ไขเป็นไฟล์ที่ใช้เชื่อมต่อฐานข้อมูลจริง

// ฟังก์ชันสำหรับเก็บ log ข้อความผิดพลาดในฐานข้อมูล
function log_error($message, $category = 'general') {
    global $conn; // เชื่อมต่อฐานข้อมูลจากไฟล์ connect.php

    // รับข้อมูลจาก session หรือค่าดีฟอลต์
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO log_error (category, message, username, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?)";

    // เตรียม statement
    if ($stmt = $conn->prepare($sql)) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("sssss", $category, $message, $username, $ip, $userAgent);
        
        // Execute คำสั่ง SQL
        if ($stmt->execute()) {
            // success
            return true;
        } else {
            // เกิดข้อผิดพลาดในการเก็บ log
            return false;
        }
    } else {
        return false;
    }
}
function log_action($message, $category = 'general') {
    global $conn; // เชื่อมต่อฐานข้อมูลจากไฟล์ connect.php

    // รับข้อมูลจาก session หรือค่าดีฟอลต์
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO log_action (category, message, username, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?)";

    // เตรียม statement
    if ($stmt = $conn->prepare($sql)) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("sssss", $category, $message, $username, $ip, $userAgent);
        
        // Execute คำสั่ง SQL
        if ($stmt->execute()) {
            // success
            return true;
        } else {
            // เกิดข้อผิดพลาดในการเก็บ log
            return false;
        }
    } else {
        return false;
    }
}
?>
