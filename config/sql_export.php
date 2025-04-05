<?php
session_start();
// require '../config/connect.php';
require_once '../config/error_log.php';
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lms_e_learning";

// ตั้งชื่อไฟล์ backup พร้อม timestamp
$date = date("Y-m-d_H-i-s");
$backupFile = "backup_{$dbname}_{$date}.sql";

// path ไปยัง mysqldump.exe (กรณีใช้ XAMPP)
$mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump.exe';

if (!file_exists($mysqldumpPath)) {
    log_error("ไม่พบ mysqldump ที่ path: $mysqldumpPath", 'export');
    echo json_encode([
        'status' => 'error',
        'message' => "ไม่พบ mysqldump.exe กรุณาตรวจสอบ path"
    ]);
    exit;
}

// คำสั่ง export
$command = "\"$mysqldumpPath\" --user=$username --password=$password --host=$host $dbname";

// เรียกใช้คำสั่ง และเก็บผลลัพธ์ไว้ในตัวแปร
exec($command, $output, $result_code);

// ตรวจสอบว่า export สำเร็จไหม
if ($result_code !== 0 || empty($output)) {
    log_error("การ export database ล้มเหลว (code: $result_code)", 'export');
    echo json_encode([
        'status' => 'error',
        'message' => "Export ล้มเหลว (code: $result_code)"
    ]);
    exit;
}

// 📌 บันทึกไฟล์ลงโฟลเดอร์ backup/
$backupDir = __DIR__ . '/../backup/'; // __DIR__ = path ของไฟล์นี้
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
}

$fullPath = $backupDir . $backupFile;
file_put_contents($fullPath, implode("\n", $output));

echo json_encode([
    'status' => 'success',
    'message' => "Backup สำเร็จ: $backupFile"
]);
