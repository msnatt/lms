<?php
// Create a full DB dump into backup/. Admin-only.
session_start();

require __DIR__ . '/connect.php';   // $servername $username $password $database
require_once __DIR__ . '/error_log.php';
include __DIR__ . '/admin-guard.php';

header('Content-Type: application/json');
require_admin_json();

/**
 * Locate mysqldump / mysql across the usual XAMPP layouts instead of a single
 * hardcoded drive.
 */
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

$dumpBin = find_mysql_binary('mysqldump');
if ($dumpBin === null) {
    log_error("mysqldump not found in any known location", 'backup');
    echo json_encode(['success' => false, 'message' => 'mysqldump_not_found']);
    exit();
}

$backupDir = __DIR__ . '/../backup/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}
// self-heal the access lock (backup/ is gitignored, so .htaccess may be missing on a fresh checkout)
if (!is_file($backupDir . '.htaccess')) {
    file_put_contents($backupDir . '.htaccess', "Require all denied\nOptions -Indexes\n");
}

$backupFile = 'backup_' . $database . '_' . date('Y-m-d_H-i-s') . '.sql';
$fullPath   = $backupDir . $backupFile;

// credentials via a throwaway option file, never on the command line
$cnf = tempnam(sys_get_temp_dir(), 'my');
file_put_contents(
    $cnf,
    "[client]\nuser=" . $username . "\npassword=" . $password . "\nhost=" . $servername . "\n"
);

try {
    $cmd = escapeshellarg($dumpBin)
        . ' --defaults-extra-file=' . escapeshellarg($cnf)
        . ' --single-transaction --routines --events '
        . escapeshellarg($database)
        . ' > ' . escapeshellarg($fullPath) . ' 2>&1';

    exec($cmd, $out, $code);

    if ($code !== 0 || !is_file($fullPath) || filesize($fullPath) === 0) {
        @unlink($fullPath);
        log_error("sql_export failed (code $code): " . implode(' ', (array) $out), 'backup');
        echo json_encode(['success' => false, 'message' => 'export_failed']);
        exit();
    }

    log_action("create backup: $backupFile (" . filesize($fullPath) . " bytes)", 'backup');
    echo json_encode(['success' => true, 'filename' => $backupFile]);
} finally {
    @unlink($cnf);
}
