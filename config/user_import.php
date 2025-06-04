<?php
require '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];
    $duplicateUsers = []; // เก็บข้อมูลซ้ำ

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // ข้าม Header บรรทัดแรก

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            list($id, $code, $name, $email, $username, $password, $telephone, $is_admin) = $data;

            // ตรวจสอบว่ามี Email นี้อยู่แล้วหรือไม่
            $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                // ถ้าไม่มี ให้ Insert ใหม่
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO user (code, name, email, username, password, telephone, is_admin) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssi", $code, $name, $email, $username, $hashedPassword, $telephone, $is_admin);
                $stmt->execute();
            } else {
                // ข้อมูลที่ซ้ำ
                $duplicateUsers[] = $name;
            }
        }
        fclose($handle);

        // คืนค่า JSON
        echo json_encode(["success" => true, "message" => "Import สำเร็จ!", "duplicates" => $duplicateUsers]);
    } else {
        echo json_encode(["success" => false, "message" => "ไม่สามารถอ่านไฟล์ CSV ได้", "duplicates" => $duplicateUsers]);
    }
}
