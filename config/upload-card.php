<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../assets/images/bg_cards/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir .  $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            echo "บันทึกสำเร็จ: " . $targetPath;
        } else {
            echo "ไม่สามารถบันทึกไฟล์ได้";
        }
    } else {
        echo "ไม่มีไฟล์ที่อัปโหลด หรือเกิดข้อผิดพลาด";
    }
} else {
    echo "ไม่อนุญาตให้เข้าถึงโดยตรง";
}
