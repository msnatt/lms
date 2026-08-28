<?php
session_start();
// ต้อง include connect.php เพื่อให้ $conn มีค่า — log_error()/log_action() ใน error_log.php
// อ่านค่านี้ผ่าน global $conn ถ้าไม่ include ตรงนี้จะเป็น null แล้วเกิด Fatal error ตอนเรียก log_*()
require_once '../config/connect.php';
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lms_e_learning";

// ตั้งชื่อไฟล์ backup พร้อม timestamp
$date = date("Y-m-d_H-i-s");
$backupFile = "backup_{$dbname}_{$date}.sql";

// หา path ของ mysqldump.exe แบบ auto-detect (แต่ละเครื่องอาจติดตั้ง XAMPP คนละไดรฟ์)
$candidates = [
    __DIR__ . '/../../../mysql/bin/mysqldump.exe',            // C:\xampp\htdocs\lms\config → C:\xampp\mysql\bin
    dirname(PHP_BINARY) . '/../mysql/bin/mysqldump.exe',       // PHP CLI (xampp/php)
    dirname(PHP_BINARY) . '/../../mysql/bin/mysqldump.exe',    // mod_php (xampp/apache/bin)
];

$mysqldumpPath = null;
foreach ($candidates as $candidate) {
    $real = realpath($candidate);
    if ($real && is_file($real)) {
        $mysqldumpPath = $real;
        break;
    }
}

if ($mysqldumpPath === null) {
    log_error("ไม่พบ mysqldump.exe ในตำแหน่งที่ตรวจสอบ: " . implode(', ', $candidates), 'export');
    echo json_encode([
        'status' => 'error',
        'message' => "ไม่พบ mysqldump.exe กรุณาตรวจสอบการติดตั้ง XAMPP"
    ]);
    exit;
}

// เตรียมโฟลเดอร์ backup/ ก่อนรันคำสั่ง
$backupDir = __DIR__ . '/../backup/'; // __DIR__ = path ของไฟล์นี้
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
}
$fullPath = $backupDir . $backupFile;

// ให้ mysqldump เขียนไฟล์ตรงด้วย --result-file แทนการ exec เก็บ output เอง (กันปัญหาไฟล์ใหญ่/line ending เพี้ยน)
$command = sprintf(
    '%s --user=%s --password=%s --host=%s --result-file=%s %s 2>&1',
    escapeshellarg($mysqldumpPath),
    escapeshellarg($username),
    escapeshellarg($password),
    escapeshellarg($host),
    escapeshellarg($fullPath),
    escapeshellarg($dbname)
);

$output = [];
$result_code = 0;
exec($command, $output, $result_code);

// ตรวจสอบว่า export สำเร็จไหม
if ($result_code !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {
    if (file_exists($fullPath)) {
        unlink($fullPath); // ลบไฟล์เปล่า/ไฟล์ค้างทิ้ง
    }
    log_error("การ export database ล้มเหลว (code: $result_code): " . implode(' ', $output), 'export');
    echo json_encode([
        'status' => 'error',
        'message' => "Export ล้มเหลว (code: $result_code)"
    ]);
    exit;
}

log_action("Export database สำเร็จ: $backupFile", 'export');
echo json_encode([
    'status' => 'success',
    'message' => "Backup สำเร็จ: $backupFile"
]);
