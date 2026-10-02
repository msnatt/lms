<?php
// List of .sql files in backup/, newest first. Admin-only.
session_start();

include __DIR__ . '/no-crash.php';
include __DIR__ . '/admin-guard.php';

require_admin_json();

header('Content-Type: application/json');

$backupDir = __DIR__ . '/../backup/';
$files = [];
$totalSize = 0;

if (is_dir($backupDir)) {
    foreach (scandir($backupDir) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'sql') {
            continue;
        }
        $full = $backupDir . $file;
        $size = @filesize($full);
        $mtime = @filemtime($full);
        if ($size === false || $mtime === false) {
            continue;
        }
        $files[] = [
            'name'     => $file,
            'size'     => $size,
            'modified' => date('Y-m-d H:i:s', $mtime),
            '_mtime'   => $mtime,
        ];
        $totalSize += $size;
    }
}

// newest first
usort($files, fn($a, $b) => $b['_mtime'] <=> $a['_mtime']);
$latest = $files[0]['modified'] ?? null;
foreach ($files as &$f) {
    unset($f['_mtime']);
}
unset($f);

echo json_encode([
    'success'    => true,
    'files'      => $files,
    'total'      => count($files),
    'total_size' => $totalSize,
    'latest'     => $latest,
], JSON_UNESCAPED_UNICODE);
