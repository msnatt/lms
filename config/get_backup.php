<?php
$backupDir = __DIR__ . '/../backup/';  // เปลี่ยน path ตามโฟลเดอร์ของคุณ
$files = [];

if (is_dir($backupDir)) {
    $scan = scandir($backupDir);
    foreach ($scan as $file) {
        if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            $filePath = $backupDir . $file;
            $files[] = [
                'name' => $file,
                'size' => filesize($filePath),
                'modified' => date("Y-m-d H:i:s", filemtime($filePath)),
            ];
        }
    }
}

// ส่งออกเป็น JSON (ถ้าจะใช้กับ fetch ใน frontend)
header('Content-Type: application/json');
echo json_encode($files);