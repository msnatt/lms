<?php
session_start();
$username = $_SESSION['username'];

if (isset($_POST['contentItems'])) {
    $contentItems = json_decode($_POST['contentItems'], true);


    foreach ($contentItems as &$item) {
        if ($item['id'] == 0 && isset($item['content'])) {
            $contentPath = $item['content'];

            // ตรวจสอบว่า path เริ่มต้นด้วย ../temp/
            if (strpos($contentPath, '../temp/') === 0) {
                $source = realpath(__DIR__ . '/' . $contentPath);
                if ($source && file_exists($source)) {
                    $filename = basename($source);

                    // ดึงชื่อ username ออกมาจาก path เช่น ../temp/username/filename.ext
                    $parts = explode('/', $contentPath);
                    $usernameIndex = array_search('temp', $parts) + 1;
                    $username = $parts[$usernameIndex] ?? 'unknown';

                    // เตรียมโฟลเดอร์ปลายทาง
                    $uploadDir = realpath(__DIR__ . '/../uploads') . '/' . $username;
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
                    }

                    // ย้ายไฟล์
                    $destination = $uploadDir . '/' . $filename;
                    if (rename($source, $destination)) {
                        // อัปเดต path ใหม่ให้ content
                        $item['content'] = '../uploads/' . $username . '/' . $filename;
                    } else {
                        echo "ไม่สามารถย้ายไฟล์ $filename ได้<br>";
                    }
                } else {
                    echo "ไม่พบไฟล์: $contentPath<br>";
                }
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'ไฟล์ถูกย้ายเรียบร้อยแล้ว',
        'updatedItems' => $contentItems
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'ไม่ได้รับข้อมูล contentItems'
    ]);
}
