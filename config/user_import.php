<?php
session_start();

include '../config/connect.php';
include '../config/admin-guard.php';

header('Content-Type: application/json');

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES["csv_file"])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ไม่พบไฟล์ CSV", "duplicates" => [], "skipped" => [], "imported" => 0]);
    exit();
}

// ตรวจนามสกุลไฟล์
$origName = $_FILES["csv_file"]["name"] ?? '';
$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
if ($ext !== 'csv') {
    echo json_encode(["success" => false, "message" => "ไฟล์ต้องเป็น .csv", "duplicates" => [], "skipped" => [], "imported" => 0]);
    exit();
}

$file = $_FILES["csv_file"]["tmp_name"];
$duplicateUsers = [];
$skippedRows = [];
$imported = 0;

if (($handle = fopen($file, "r")) === FALSE) {
    echo json_encode(["success" => false, "message" => "ไม่สามารถอ่านไฟล์ CSV ได้", "duplicates" => [], "skipped" => [], "imported" => 0]);
    exit();
}

// อ่าน header row -> map ชื่อคอลัมน์เป็น index
$header = fgetcsv($handle);
if ($header === FALSE) {
    fclose($handle);
    echo json_encode(["success" => false, "message" => "ไฟล์ว่างเปล่า", "duplicates" => [], "skipped" => [], "imported" => 0]);
    exit();
}
$header = array_map(fn($h) => strtolower(trim($h)), $header);
$idx = array_flip($header);

$required = ['code', 'name', 'email', 'username'];
foreach ($required as $col) {
    if (!isset($idx[$col])) {
        fclose($handle);
        echo json_encode([
            "success" => false,
            "message" => "CSV ต้องมีคอลัมน์: " . implode(", ", $required),
            "duplicates" => [],
            "skipped" => [],
            "imported" => 0
        ]);
        exit();
    }
}

$get = function ($row, $col) use ($idx) {
    return isset($idx[$col]) && isset($row[$idx[$col]]) ? trim($row[$idx[$col]]) : '';
};

$rank = 0;
$lineNo = 1;
while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
    $lineNo++;
    if (count(array_filter($data, fn($v) => trim((string) $v) !== '')) === 0) {
        continue; // แถวว่าง
    }

    $code     = $get($data, 'code');
    $name     = $get($data, 'name');
    $email    = $get($data, 'email');
    $username = $get($data, 'username');
    $telephone = $get($data, 'telephone');
    $password = $get($data, 'password');
    $is_admin = ($get($data, 'is_admin') === '1') ? 1 : 0;

    // คอลัมน์บังคับไม่ครบ -> ข้าม
    if ($code === '' || $name === '' || $email === '' || $username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $skippedRows[] = "line $lineNo";
        continue;
    }
    if ($password === '') {
        $password = bin2hex(random_bytes(6));
    }

    // ซ้ำไหม
    $stmt = $conn->prepare("SELECT id FROM user WHERE (email = ? OR username = ?) AND is_deleted = 0");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $duplicateUsers[] = $name;
        $stmt->close();
        continue;
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare(
        "INSERT INTO user (code, name, email, username, password, rank, telephone, is_admin)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssisi", $code, $name, $email, $username, $hashedPassword, $rank, $telephone, $is_admin);
    $stmt->execute();
    $stmt->close();
    $imported++;
}
fclose($handle);

echo json_encode([
    "success"    => true,
    "message"    => "Import สำเร็จ!",
    "imported"   => $imported,
    "duplicates" => $duplicateUsers,
    "skipped"    => $skippedRows
]);
