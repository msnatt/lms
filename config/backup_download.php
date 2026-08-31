<?php
// Streams one .sql file out of backup/ to an admin. This is the ONLY path by
// which a dump leaves the server — backup/.htaccess blocks direct access.
session_start();

include __DIR__ . '/no-crash.php';
include __DIR__ . '/connect.php';
include __DIR__ . '/admin-guard.php';

require_admin_json();

$backupDir = realpath(__DIR__ . '/../backup');
$name = basename($_GET['file'] ?? '');

if ($backupDir === false || $name === '' || strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'sql') {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'bad_request']);
    exit();
}

$path = realpath($backupDir . DIRECTORY_SEPARATOR . $name);

// containment check — realpath must sit directly under backup/
if ($path === false || strpos($path, $backupDir . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'not_found']);
    exit();
}

log_action("download backup: $name", 'backup');

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $name . '"');
header('Content-Length: ' . filesize($path));
header('X-Content-Type-Options: nosniff');
readfile($path);
