<?php
session_start();

// ต้อง login ก่อนถึงอัปโหลดไฟล์เนื้อหาคอร์สชั่วคราวได้ (เดิม fallback เป็น 'guest'
// เมื่อไม่มี session ทำให้ใครก็ใช้งานได้โดยไม่ต้อง login)
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'results' => 'forbidden']);
    exit;
}

$username = $_SESSION['username'];
$uploadDir = "../temp/$username/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // whitelist นามสกุลไฟล์ตามชนิดเนื้อหาที่หน้า course_edit/course_create รองรับจริง
    // (รูปภาพ / วิดีโอ / PDF / โมเดล 3 มิติ) กัน .php ถูกอัปโหลดแล้วย้ายเข้า uploads/ (public) ภายหลัง
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'webm', 'mov', 'pdf', 'glb', 'gltf', 'bin'];
    $maxSize = 50 * 1024 * 1024; // 50MB (รองรับไฟล์วิดีโอ/โมเดล 3 มิติ)

    $fileName = basename($_FILES['file']['name']);
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt, true)) {
        echo json_encode(['success' => false, 'results' => 'ชนิดไฟล์ไม่ได้รับอนุญาต', 'filename' => $fileName]);
        exit;
    }
    if ($_FILES['file']['size'] > $maxSize) {
        echo json_encode(['success' => false, 'results' => 'ไฟล์มีขนาดใหญ่เกินไป', 'filename' => $fileName]);
        exit;
    }

    $fileTmpPath = $_FILES['file']['tmp_name'];
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destination)) {
        echo json_encode(['success' => true, 'results' => $destination, 'filename' => $fileName]);
    } else {
        echo json_encode(['success' => false, 'results' => 'Failed to move file', 'filename' => $fileName]);
    }
    exit;
}
?>
