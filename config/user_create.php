<?php
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit();
}

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit();
}

$code      = trim($_POST['code'] ?? '');
$name      = trim($_POST['name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$username  = trim($_POST['username'] ?? '');
$password  = $_POST['password'] ?? '';
$telephone = trim($_POST['telephone'] ?? '');
$is_admin  = (isset($_POST['is_admin']) && $_POST['is_admin'] == '1') ? 1 : 0;

// ตรวจฟิลด์ครบ
if ($code === '' || $name === '' || $email === '' || $username === '' || $password === '' || $telephone === '') {
    echo json_encode(["success" => false, "message" => "incomplete"]);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "email_invalid"]);
    exit();
}
if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "password_short"]);
    exit();
}
// ความยาวตาม DDL
if (
    strlen($code) > 11 || mb_strlen($name) > 50 || strlen($email) > 50 ||
    strlen($username) > 20 || strlen($telephone) > 10
) {
    echo json_encode(["success" => false, "message" => "too_long"]);
    exit();
}

$conn->begin_transaction();
try {
    // ตรวจซ้ำ
    $stmt = $conn->prepare("SELECT id FROM user WHERE (email = ? OR username = ?) AND is_deleted = 0");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "duplicate"]);
        exit();
    }
    $stmt->close();

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $rank = 0;
    $stmt = $conn->prepare(
        "INSERT INTO user (code, name, email, username, password, rank, telephone, is_admin)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssisi", $code, $name, $email, $username, $hashed, $rank, $telephone, $is_admin);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "created"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "error: " . $e->getMessage()]);
}

$conn->close();
