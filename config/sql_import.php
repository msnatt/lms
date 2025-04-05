<?php
include '../config/connect.php'; // รวมการเชื่อมต่อฐานข้อมูล
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

    // อ่านไฟล์ .sql
    $sqlContent = file_get_contents($fileTmpPath);

    // สั่งให้ MySQL นำเข้าไฟล์ .sql
    $command = "mysql -u $username -p$password -h $servername $database < $fileTmpPath";
    
    $output = null;
    $resultCode = null;
    exec($command, $output, $resultCode);

    // เช็คผลลัพธ์
    if ($resultCode === 0) {
        log_action("Import สำเร็จ: $fileName", 'import');
        echo json_encode(['status' => 'success', 'message' => 'Import สำเร็จ']);
    } else {
        log_action("Import ล้มเหลว: $fileName", 'import');
        log_error("Import ล้มเหลว: $fileName", 'import');
        echo json_encode(['status' => 'error', 'message' => 'Import ล้มเหลว']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'กรุณาเลือกไฟล์เพื่อทำการนำเข้า']);
}
?>
