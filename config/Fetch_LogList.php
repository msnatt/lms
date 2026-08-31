<?php
// Unified, paginated log reader for pages/log.php. Admin-only.
// Serves all three log tables through one whitelist map so the table/column
// names are never taken from user input.
session_start();

include "../config/no-crash.php";
include "../config/connect.php";
include "../config/admin-guard.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_admin_json();

header('Content-Type: application/json');

// table + column names come from here, NEVER from $_GET
$MAP = [
    'login'  => ['table' => 'log_login',  'time' => 'log_time',   'cat' => 'action',   'msg' => null],
    'error'  => ['table' => 'log_error',  'time' => 'created_at',  'cat' => 'category', 'msg' => 'message'],
    'action' => ['table' => 'log_action', 'time' => 'created_at',  'cat' => 'category', 'msg' => 'message'],
];

$typeKey = $_GET['type'] ?? 'login';
if (!isset($MAP[$typeKey])) {
    echo json_encode(['success' => false, 'message' => 'bad_type']);
    exit();
}
$t = $MAP[$typeKey];

$page    = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 50;
if ($page < 1) {
    $page = 1;
}
if ($perPage < 10) {
    $perPage = 10;
}
if ($perPage > 200) {
    $perPage = 200;
}

// total count
$total = 0;
$countRes = $conn->query("SELECT COUNT(*) AS c FROM {$t['table']}");
if ($countRes && ($row = $countRes->fetch_assoc())) {
    $total = (int) $row['c'];
}
$pages  = $total > 0 ? (int) ceil($total / $perPage) : 1;
if ($page > $pages) {
    $page = $pages;
}
$offset = ($page - 1) * $perPage;

$msgCol = $t['msg'] ? $t['msg'] : "NULL";
$sql = "SELECT id,
               {$t['time']} AS log_time,
               username,
               {$t['cat']}  AS category,
               {$msgCol}    AS message,
               ip_address,
               user_agent
        FROM {$t['table']}
        ORDER BY id DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = [
        'id'         => (int) $row['id'],
        'time'       => $row['log_time'],
        'username'   => $row['username'],
        'category'   => $row['category'],
        'message'    => $row['message'],
        'ip_address' => $row['ip_address'],
        'user_agent' => $row['user_agent'],
    ];
}

echo json_encode([
    'success'  => true,
    'rows'     => $rows,
    'total'    => $total,
    'page'     => $page,
    'per_page' => $perPage,
    'pages'    => $pages,
], JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
