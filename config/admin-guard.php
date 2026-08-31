<?php
// Admin-only guard for JSON endpoints. include AFTER session_start().
// Page-level UI gating stays inline in pages/ files (per CLAUDE.md).

function require_admin_json()
{
    $me = $_SESSION['user'] ?? null;
    if (!is_array($me) || ($me['is_admin'] ?? 0) != 1) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'forbidden']);
        exit();
    }
}

// Any logged-in user (not necessarily admin). For endpoints shared with
// non-admin pages such as chat.
function require_login_json()
{
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'forbidden']);
        exit();
    }
}
