<?php
// CSV export of one log table. Admin-only. Mirrors config/user_export.php:
// returns base64-encoded CSV inside JSON so the page can build a data: URL.
session_start();

include '../config/no-crash.php';
include '../config/connect.php';
include '../config/admin-guard.php';

require_admin_json();

header('Content-Type: application/json');

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

try {
    $msgCol = $t['msg'] ? $t['msg'] : "NULL";
    $sql = "SELECT {$t['time']} AS log_time, username, {$t['cat']} AS category,
                   {$msgCol} AS message, ip_address, user_agent
            FROM {$t['table']}
            ORDER BY id DESC";
    $result = $conn->query($sql);

    ob_start();
    $out = fopen("php://output", "w");
    fputcsv($out, ["time", "username", "category", "message", "ip_address", "user_agent"]);
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        fputcsv($out, [
            $row['log_time'],
            $row['username'],
            $row['category'],
            $row['message'],
            $row['ip_address'],
            $row['user_agent'],
        ]);
        $count++;
    }
    fclose($out);
    $csv = ob_get_clean();

    log_action("export log ($typeKey): $count row(s)", 'export');

    echo json_encode([
        'success'  => true,
        'filename' => 'log_' . $typeKey . '_' . date('Y-m-d') . '.csv',
        'filedata' => base64_encode($csv),
    ]);
} catch (Throwable $e) {
    log_error("log_export failed: " . $e->getMessage(), 'export');
    echo json_encode(['success' => false, 'message' => 'error']);
}

$conn->close();
