<?php
// User list for the UMS page. Admin-only. Returns explicit columns — never
// password. Mirrors the Fetch_CertStudent.php pattern.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_admin_json();

$sql = "SELECT id, code, name, email, username, telephone, is_admin, create_date
        FROM user
        WHERE is_deleted = 0
        ORDER BY code";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'id'          => $row['id'],
        'code'        => $row['code'],
        'name'        => $row['name'],
        'email'       => $row['email'],
        'username'    => $row['username'],
        'telephone'   => $row['telephone'],
        'is_admin'    => $row['is_admin'],
        'create_date' => $row['create_date'],
    ];
}

header('Content-Type: application/json');
echo json_encode($users, JSON_UNESCAPED_UNICODE);

$conn->close();
