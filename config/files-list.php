<?php
$folder = '../templates'; // ชื่อโฟลเดอร์ (relative path)
$files = [];

// ตรวจสอบว่าโฟลเดอร์มีอยู่
if (is_dir($folder)) {
    foreach (scandir($folder) as $file) {
        if ($file !== '.' && $file !== '..' && is_file($folder . '/' . $file)) {
            $files[] = $file;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($files);