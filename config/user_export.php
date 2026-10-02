<?php
session_start();

include '../config/connect.php';
include '../config/admin-guard.php';

require_admin_json();

header('Content-Type: application/json');

try {
    // เปิด Output Buffering เพื่อจับ CSV ที่ fputcsv เขียนออก php://output
    ob_start();
    $output = fopen("php://output", "w");

    // Header ของ CSV — คอลัมน์ตรงกับที่ user_import.php รับ (password ปล่อยว่าง)
    fputcsv($output, ["code", "name", "email", "username", "password", "telephone", "is_admin"]);

    $sql = "SELECT code, name, email, username, telephone, is_admin FROM user WHERE is_deleted = 0 ORDER BY code";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['code'],
            $row['name'],
            $row['email'],
            $row['username'],
            '', // password — ไม่ export ออก; import จะสุ่มให้ถ้าเว้นว่าง
            $row['telephone'],
            $row['is_admin'],
        ]);
    }
    fclose($output);

    $csvContent = ob_get_clean();

    echo json_encode([
        "success"  => true,
        "message"  => "Export สำเร็จ",
        "filename" => "users_export.csv",
        "filedata" => base64_encode($csvContent)
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()
    ]);
}
exit();
