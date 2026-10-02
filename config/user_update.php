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

$user_id   = $_POST['user_id'] ?? null;
$name      = trim($_POST['name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$username  = trim($_POST['username'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');

if (!$user_id || $name === '' || $email === '' || $username === '' || $telephone === '') {
    echo json_encode(["success" => false, "message" => "incomplete"]);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "email_invalid"]);
    exit();
}
if (
    mb_strlen($name) > 50 || strlen($email) > 50 ||
    strlen($username) > 20 || strlen($telephone) > 10
) {
    echo json_encode(["success" => false, "message" => "too_long"]);
    exit();
}

$conn->begin_transaction();
try {
    // มี user นี้จริงไหม
    $stmt = $conn->prepare("SELECT id FROM user WHERE id = ? AND is_deleted = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        $conn->rollback();
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "not_found"]);
        exit();
    }
    $stmt->close();

    // ซ้ำกับคนอื่นไหม (ยกเว้นตัวเอง)
    $stmt = $conn->prepare("SELECT id FROM user WHERE (email = ? OR username = ?) AND id != ? AND is_deleted = 0");
    $stmt->bind_param("ssi", $email, $username, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "duplicate"]);
        exit();
    }
    $stmt->close();

    $stmt = $conn->prepare(
        "UPDATE user SET name = ?, email = ?, username = ?, telephone = ?, update_date = NOW() WHERE id = ?"
    );
    $stmt->bind_param("ssssi", $name, $email, $username, $telephone, $user_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "updated"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "error: " . $e->getMessage()]);
}

$conn->close();
