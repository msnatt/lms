<?php
require '../config/connect.php';

try {
    // เปิด Output Buffering
    ob_start();
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=users_export.csv");

    $output = fopen("php://output", "w");

    // เขียน Header ลง CSV
    fputcsv($output, ["ID", "Code", "Name", "Email", "Username", "Telephone", "Created", "Updated", "Role"]);

    $sql = "SELECT id, code, name, email, username, telephone, create_date, update_date, is_admin FROM user WHERE is_deleted = 0";
    $result = $conn->query($sql);

    // วนลูปดึงข้อมูลและเขียนลงไฟล์ CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);

    // ดึง Output Buffer ไปใส่ตัวแปร
    $csvContent = ob_get_clean();

    // คืนค่า JSON พร้อมไฟล์ CSV (Base64)
    echo json_encode([
        "success" => true,
        "message" => "Export สำเร็จ",
        "filename" => "users_export.csv",
        "filedata" => base64_encode($csvContent) // แปลงไฟล์เป็น Base64
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()
    ]);
}
exit();
