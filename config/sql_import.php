<?php
// Import a .sql file over the live database. Admin-only, POST-only.
// Always takes a pre-import backup first so the operation is recoverable.
session_start();

require __DIR__ . '/connect.php';   // $servername $username $password $database
require_once __DIR__ . '/error_log.php';
include __DIR__ . '/admin-guard.php';

header('Content-Type: application/json');
require_admin_json();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'method_not_allowed']);
    exit();
}

function find_mysql_binary($name)
{
    $candidates = [
        'C:/xampp/mysql/bin/' . $name . '.exe',
        'D:/xampp/mysql/bin/' . $name . '.exe',
        'C:/xampp/mysql/bin/' . $name,
        '/opt/lampp/bin/' . $name,
        '/usr/bin/' . $name,
        '/usr/local/bin/' . $name,
    ];
    foreach ($candidates as $c) {
        if (is_file($c)) {
            return $c;
        }
    }
    return null;
}

$MAX_BYTES = 64 * 1024 * 1024;

$f = $_FILES['sqlFile'] ?? null;
if (!$f || ($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'no_file']);
    exit();
}
if ($f['size'] <= 0 || $f['size'] > $MAX_BYTES) {
    echo json_encode(['status' => 'error', 'message' => 'bad_size']);
    exit();
}
if (strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) !== 'sql') {
    echo json_encode(['status' => 'error', 'message' => 'not_sql']);
    exit();
}

// peek: the head of the file must actually look like SQL
$head = strtoupper((string) file_get_contents($f['tmp_name'], false, null, 0, 4096));
if (!preg_match('/\b(CREATE|INSERT|DROP|ALTER|SET|USE|LOCK|--|\/\*)\b/', $head)) {
    echo json_encode(['status' => 'error', 'message' => 'not_sql']);
    exit();
}

$mysqlBin = find_mysql_binary('mysql');
$dumpBin  = find_mysql_binary('mysqldump');
if ($mysqlBin === null || $dumpBin === null) {
    log_error("mysql/mysqldump not found for import", 'import');
    echo json_encode(['status' => 'error', 'message' => 'mysql_not_found']);
    exit();
}

$backupDir = __DIR__ . '/../backup/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}
if (!is_file($backupDir . '.htaccess')) {
    file_put_contents($backupDir . '.htaccess', "Require all denied\nOptions -Indexes\n");
}

$cnf = tempnam(sys_get_temp_dir(), 'my');
file_put_contents(
    $cnf,
    "[client]\nuser=" . $username . "\npassword=" . $password . "\nhost=" . $servername . "\n"
);

try {
    // 1. pre-import safety backup
    $safeName = 'pre-import_' . date('Y-m-d_H-i-s') . '.sql';
    $safePath = $backupDir . $safeName;
    $dumpCmd = escapeshellarg($dumpBin)
        . ' --defaults-extra-file=' . escapeshellarg($cnf)
        . ' --single-transaction --routines --events '
        . escapeshellarg($database)
        . ' > ' . escapeshellarg($safePath) . ' 2>&1';
    exec($dumpCmd, $dOut, $dCode);
    if ($dCode !== 0 || !is_file($safePath) || filesize($safePath) === 0) {
        @unlink($safePath);
        log_error("import aborted — pre-backup failed (code $dCode)", 'import');
        echo json_encode(['status' => 'error', 'message' => 'prebackup_failed']);
        exit();
    }

    // 2. run the import
    $impCmd = escapeshellarg($mysqlBin)
        . ' --defaults-extra-file=' . escapeshellarg($cnf) . ' '
        . escapeshellarg($database)
        . ' < ' . escapeshellarg($f['tmp_name']) . ' 2>&1';
    exec($impCmd, $iOut, $iCode);

    if ($iCode === 0) {
        log_action("import ok: " . $f['name'] . " (pre-backup $safeName)", 'import');
        echo json_encode(['status' => 'success', 'message' => 'ok', 'presafe' => $safeName]);
    } else {
        log_action("import failed: " . $f['name'], 'import');
        log_error("sql_import failed (code $iCode): " . implode(' ', (array) $iOut), 'import');
        echo json_encode(['status' => 'error', 'message' => 'import_failed', 'presafe' => $safeName]);
    }
} finally {
    @unlink($cnf);
}
