<?php
include '../config/connect.php'; // รวมการเชื่อมต่อฐานข้อมูล (ให้ $servername, $username, $password, $database)
require_once '../config/error_log.php';

// ตรวจสอบว่าไฟล์ถูกส่งมาไหม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['sqlFile'])) {
    $fileTmpPath = $_FILES['sqlFile']['tmp_name'];
    $fileName = $_FILES['sqlFile']['name'];

    // ตรวจสอบว่าเป็นไฟล์ .sql
    if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'sql') {
        echo json_encode(['status' => 'error', 'message' => 'กรุณาเลือกไฟล์ .sql เท่านั้น']);
        exit();
    }

    // หา path ของ mysql.exe แบบ auto-detect (แต่ละเครื่องอาจติดตั้ง XAMPP คนละไดรฟ์)
    $candidates = [
        __DIR__ . '/../../../mysql/bin/mysql.exe',            // C:\xampp\htdocs\lms\config → C:\xampp\mysql\bin
        dirname(PHP_BINARY) . '/../mysql/bin/mysql.exe',       // PHP CLI (xampp/php)
        dirname(PHP_BINARY) . '/../../mysql/bin/mysql.exe',    // mod_php (xampp/apache/bin)
    ];

    $mysqlPath = null;
    foreach ($candidates as $candidate) {
        $real = realpath($candidate);
        if ($real && is_file($real)) {
            $mysqlPath = $real;
            break;
        }
    }

    if ($mysqlPath === null) {
        log_error("ไม่พบ mysql.exe ในตำแหน่งที่ตรวจสอบ: " . implode(', ', $candidates), 'import');
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบ mysql.exe กรุณาตรวจสอบการติดตั้ง XAMPP']);
        exit();
    }

    // ล้างฐานข้อมูลเดิมทั้งหมดแล้วสร้างใหม่ให้ว่างเปล่า ก่อนนำเข้าไฟล์
    // กันปัญหา "Table already exists" เวลาไฟล์ที่นำเข้าไม่มี DROP TABLE IF EXISTS กำกับทุกตาราง
    // (เช่น ไฟล์ schema dump ดิบที่ export มาจากเครื่องมืออื่น หรือไฟล์เก่าที่ export ก่อนแก้บั๊กนี้)
    $charset = 'utf8mb4';
    $collation = 'utf8mb4_general_ci';
    try {
        $res = $conn->query(
            "SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME
             FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '" . $conn->real_escape_string($database) . "'"
        );
        if ($res && ($row = $res->fetch_assoc())) {
            $charset = $row['DEFAULT_CHARACTER_SET_NAME'] ?: $charset;
            $collation = $row['DEFAULT_COLLATION_NAME'] ?: $collation;
        }

        $conn->query("DROP DATABASE IF EXISTS `$database`");
        $conn->query("CREATE DATABASE `$database` CHARACTER SET $charset COLLATE $collation");
        $conn->select_db($database); // reselect ฐานข้อมูลที่เพิ่งสร้างใหม่ให้ connection ปัจจุบัน
    } catch (\Throwable $e) {
        // drop/create ล้มเหลว — ฐานข้อมูลอาจอยู่ในสถานะไม่สมบูรณ์ (ถูกลบไปแล้วแต่สร้างใหม่ไม่สำเร็จ)
        // ต้องแจ้งเตือนให้ชัดเจนที่สุด เพราะเป็นสถานการณ์ร้ายแรง
        error_log("[sql_import] DROP/CREATE DATABASE failed: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'ล้างฐานข้อมูลเดิมก่อนนำเข้าไม่สำเร็จ: ' . $e->getMessage() . ' — กรุณาตรวจสอบฐานข้อมูลด้วยตนเองก่อนลองใหม่'
        ]);
        exit();
    }

    // สั่งให้ MySQL นำเข้าไฟล์ .sql (ข้าม --password ถ้ารหัสว่าง กัน mysql ค้างรอ prompt)
    $passwordFlag = $password !== '' ? '--password=' . escapeshellarg($password) : '';
    $command = sprintf(
        '%s --user=%s %s --host=%s %s < %s 2>&1',
        escapeshellarg($mysqlPath),
        escapeshellarg($username),
        $passwordFlag,
        escapeshellarg($servername),
        escapeshellarg($database),
        escapeshellarg($fileTmpPath)
    );

    $output = null;
    $resultCode = null;
    exec($command, $output, $resultCode);

    // เช็คผลลัพธ์
    if ($resultCode === 0) {
        log_action("Import สำเร็จ: $fileName", 'import');
        echo json_encode(['status' => 'success', 'message' => 'Import สำเร็จ']);
    } else {
        // ดึงข้อความ error จริงจาก mysql client (เช่น "Table 'x' already exists")
        // มาแสดงให้ผู้ใช้เห็นด้วย แทนที่จะบอกแค่ "ล้มเหลว" เฉย ๆ โดยไม่รู้สาเหตุ
        $errorDetail = trim(implode('; ', $output));
        log_action("Import ล้มเหลว: $fileName", 'import');
        log_error("Import ล้มเหลว: $fileName (code: $resultCode) $errorDetail", 'import');
        echo json_encode([
            'status' => 'error',
            'message' => 'Import ล้มเหลว' . ($errorDetail !== '' ? ": $errorDetail" : '')
        ]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'กรุณาเลือกไฟล์เพื่อทำการนำเข้า']);
}
?>
