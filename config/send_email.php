<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../config/connect.php';

header('Content-Type: application/json');

// เฉพาะแอดมินเท่านั้นที่ส่งอีเมลผ่านหน้านี้ได้
if (!isset($_SESSION['user_id']) || empty($_SESSION['user']['is_admin'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "forbidden"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method_not_allowed"]);
    exit;
}

$message = $_POST['email_message'] ?? '';
$singleTo = $_POST['email_to'] ?? '';
$recipientsInput = $_POST['recipients'] ?? [];

if (!is_array($recipientsInput)) {
    $recipientsInput = [$recipientsInput];
}
if ($singleTo) {
    $recipientsInput[] = $singleTo;
}

// dedupe + validate
$recipients = [];
foreach ($recipientsInput as $r) {
    $r = trim($r);
    if ($r && filter_var($r, FILTER_VALIDATE_EMAIL) && !in_array($r, $recipients, true)) {
        $recipients[] = $r;
    }
}

if (empty($recipients) || !$message) {
    echo json_encode(["success" => false, "message" => "noemail"]);
    exit;
}

$mailConfigPath = __DIR__ . '/mail-credentials.php';
if (!file_exists($mailConfigPath)) {
    echo json_encode(["success" => false, "message" => "mailnotconfigured"]);
    exit;
}
$mailConfig = require $mailConfigPath;
if (empty($mailConfig['password'])) {
    echo json_encode(["success" => false, "message" => "mailnotconfigured"]);
    exit;
}

$sentCount = 0;
$failedCount = 0;

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['secure'];
    $mail->Port = $mailConfig['port'];
    $mail->SMTPKeepAlive = true;

    $mail->setFrom($mailConfig['from'], $mailConfig['fromname']);
    $mail->isHTML(true);
    $mail->Subject = 'แจ้งเตือนข้อความผ่าน E-mail';
    $mail->Body = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    foreach ($recipients as $to) {
        try {
            $mail->clearAddresses();
            $mail->addAddress($to);
            $mail->send();
            $sentCount++;
        } catch (Exception $e) {
            $failedCount++;
            log_error("ส่งอีเมลไม่สำเร็จถึง {$to}: " . $mail->ErrorInfo, "email");
        }
    }

    $mail->smtpClose();
} catch (Exception $e) {
    log_error("ตั้งค่า SMTP ไม่สำเร็จ: " . $e->getMessage(), "email");
    echo json_encode(["success" => false, "message" => "sendfailed"]);
    exit;
}

if ($sentCount > 0) {
    log_action("ส่งอีเมลแจ้งเตือนถึง {$sentCount} ผู้รับ", "email");
}

if ($sentCount > 0 && $failedCount === 0) {
    echo json_encode(["success" => true, "message" => "sendsuccess", "sent" => $sentCount, "failed" => $failedCount]);
} elseif ($sentCount > 0 && $failedCount > 0) {
    echo json_encode(["success" => true, "message" => "sendpartial", "sent" => $sentCount, "failed" => $failedCount]);
} else {
    echo json_encode(["success" => false, "message" => "sendfailed", "sent" => $sentCount, "failed" => $failedCount]);
}
