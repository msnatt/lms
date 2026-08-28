<?php
// เชื่อมต่อฐานข้อมูล
// include_once '../config/connect.php'; // แก้ไขเป็นไฟล์ที่ใช้เชื่อมต่อฐานข้อมูลจริง

// ฟังก์ชันสำหรับเก็บ log ข้อความผิดพลาดในฐานข้อมูล
// หมายเหตุ: ห้ามให้ฟังก์ชัน log_* โยน exception ออกไปเด็ดขาด เพราะจุดที่เรียกใช้ (เช่น sql_import.php
// ตอน drop/create database ใหม่) อาจถูกเรียกในช่วงที่ตาราง log_error/log_action ยังไม่มีอยู่จริง
// (PHP 8.1+ ตั้ง mysqli ให้ throw mysqli_sql_exception เป็นค่า default) ถ้าปล่อยให้หลุดออกไปจะกลาย
// เป็น Fatal error ทำให้ response ที่ควรเป็น JSON กลายเป็น HTML error แทน
function log_error($message, $category = 'general') {
    global $conn; // เชื่อมต่อฐานข้อมูลจากไฟล์ connect.php

    if (!$conn) {
        return false;
    }

    // รับข้อมูลจาก session หรือค่าดีฟอลต์
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    try {
        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO log_error (category, message, username, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?)";

        // เตรียม statement
        if ($stmt = $conn->prepare($sql)) {
            // ผูกพารามิเตอร์
            $stmt->bind_param("sssss", $category, $message, $username, $ip, $userAgent);

            // Execute คำสั่ง SQL
            return (bool) $stmt->execute();
        }
        return false;
    } catch (\Throwable $e) {
        // ตาราง log_error ยังไม่มี/เชื่อมต่อมีปัญหา — ไม่ให้ล้มทั้ง request เพราะ log ไม่สำเร็จ
        return false;
    }
}
function log_action($message, $category = 'general') {
    global $conn; // เชื่อมต่อฐานข้อมูลจากไฟล์ connect.php

    if (!$conn) {
        return false;
    }

    // รับข้อมูลจาก session หรือค่าดีฟอลต์
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    try {
        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO log_action (category, message, username, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?)";

        // เตรียม statement
        if ($stmt = $conn->prepare($sql)) {
            // ผูกพารามิเตอร์
            $stmt->bind_param("sssss", $category, $message, $username, $ip, $userAgent);

            // Execute คำสั่ง SQL
            return (bool) $stmt->execute();
        }
        return false;
    } catch (\Throwable $e) {
        // ตาราง log_action ยังไม่มี/เชื่อมต่อมีปัญหา — ไม่ให้ล้มทั้ง request เพราะ log ไม่สำเร็จ
        return false;
    }
}
?>
