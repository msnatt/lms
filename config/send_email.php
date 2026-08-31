<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../config/no-crash.php";
include "../config/connect.php";       // $conn + log_error()/log_action()
include "../config/admin-guard.php";
require '../vendor/autoload.php';

header('Content-Type: application/json');

require_admin_json();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'method_not_allowed']);
    exit();
}

// ---------- input ----------
$subject = trim($_POST['subject'] ?? '');
$message = (string) ($_POST['message'] ?? '');
$rawRecipients = $_POST['recipients'] ?? '[]';

if ($subject === '' || trim($message) === '' || mb_strlen($subject) > 200) {
    echo json_encode(['success' => false, 'message' => 'incomplete']);
    exit();
}

$list = json_decode($rawRecipients, true);
if (!is_array($list)) {
    $list = [];
}

$valid = [];
$invalid = [];
foreach ($list as $addr) {
    $addr = trim((string) $addr);
    if ($addr === '') {
        continue;
    }
    if (filter_var($addr, FILTER_VALIDATE_EMAIL)) {
        $valid[] = $addr;
    } else {
        $invalid[] = $addr;
    }
}
$valid = array_values(array_unique($valid));

if (count($valid) === 0) {
    echo json_encode(['success' => false, 'message' => 'no_valid_recipient', 'invalid' => $invalid]);
    exit();
}
if (count($valid) > 100) {
    echo json_encode(['success' => false, 'message' => 'too_many']);
    exit();
}

// ---------- load SMTP config (never hardcode / never echo) ----------
$cfgPath = __DIR__ . '/mail-credentials.php';
if (!is_file($cfgPath)) {
    log_error('mail-credentials.php missing', 'email');
    echo json_encode(['success' => false, 'message' => 'mail_not_configured']);
    exit();
}
$mailcfg = require $cfgPath;
foreach (['host', 'username', 'password', 'secure', 'port', 'from', 'fromname'] as $k) {
    if (!isset($mailcfg[$k]) || $mailcfg[$k] === '') {
        log_error("mail-credentials.php missing key: $k", 'email');
        echo json_encode(['success' => false, 'message' => 'mail_not_configured']);
        exit();
    }
}

// ---------- send ----------
$sent = [];
$failed = [];

try {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = $mailcfg['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $mailcfg['username'];
    $mail->Password = $mailcfg['password'];
    $mail->SMTPSecure = $mailcfg['secure'];
    $mail->Port = (int) $mailcfg['port'];
    $mail->SMTPKeepAlive = true;

    $mail->setFrom($mailcfg['from'], $mailcfg['fromname']);
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $safe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $mail->Body = nl2br($safe);
    $mail->AltBody = $message;

    foreach ($valid as $to) {
        try {
            $mail->clearAddresses();
            $mail->addAddress($to);
            $mail->send();
            $sent[] = $to;
        } catch (Exception $e) {
            $failed[] = $to;
            log_error("send_email to $to failed: " . $mail->ErrorInfo, 'email');
        }
    }
    $mail->smtpClose();
} catch (Exception $e) {
    log_error('send_email fatal: ' . $e->getMessage(), 'email');
    echo json_encode(['success' => false, 'message' => 'send_error']);
    exit();
}

if (count($sent) > 0) {
    log_action('sent email "' . $subject . '" to ' . count($sent) . ' recipient(s)', 'email');
}

echo json_encode([
    'success' => count($sent) > 0,
    'sent'    => count($sent),
    'failed'  => $failed,
    'invalid' => $invalid,
    'message' => count($sent) > 0 ? 'sent' : 'send_error',
]);
