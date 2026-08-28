<?php
session_start();

// อัปโหลดรูปการ์ดคอร์ส — จำกัดเฉพาะ admin เท่านั้น (เดิมไม่มีการเช็คสิทธิ์เลยแม้แต่นิดเดียว
// ใครก็ POST ไฟล์เข้ามาได้ตรงๆ โดยไม่ต้อง login เป็นช่องโหว่ arbitrary file upload)
if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    die("forbidden");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // whitelist นามสกุลไฟล์รูปภาพ + จำกัดขนาด กัน .php/.phtml ถูกอัปโหลดเข้าโฟลเดอร์ public
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt, true)) {
            echo "ชนิดไฟล์ไม่ได้รับอนุญาต";
            exit();
        }
        if ($_FILES['image']['size'] > $maxSize) {
            echo "ไฟล์มีขนาดใหญ่เกินไป";
            exit();
        }

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
