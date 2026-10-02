<?php
// Delete one .sql file from backup/. Admin-only, POST-only.
session_start();

include __DIR__ . '/no-crash.php';
include __DIR__ . '/connect.php';
include __DIR__ . '/admin-guard.php';

header('Content-Type: application/json');
require_admin_json();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'method_not_allowed']);
    exit();
}

$backupDir = realpath(__DIR__ . '/../backup');
$name = basename($_POST['file'] ?? '');

if ($backupDir === false || $name === '' || strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'sql') {
    echo json_encode(['success' => false, 'message' => 'bad_request']);
    exit();
}

$path = realpath($backupDir . DIRECTORY_SEPARATOR . $name);

if ($path === false || strpos($path, $backupDir . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'not_found']);
    exit();
}

if (@unlink($path)) {
    log_action("delete backup: $name", 'backup');
    echo json_encode(['success' => true]);
} else {
    log_error("backup_delete failed: $name", 'backup');
    echo json_encode(['success' => false, 'message' => 'error']);
}
