<?php
session_start();


function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.php");
        exit();
    }
}

function logout()
{
    // Logging logout
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        include "../config/connect.php";
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $logout_action = 'logout';

        // prepared statement — $user_agent มาจาก header ของ client ห้ามต่อสตริงลง SQL
        $log_stmt = $conn->prepare("INSERT INTO log_login (user_id, username, action, ip_address, user_agent)
                    VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("issss", $user_id, $username, $logout_action, $ip_address, $user_agent);
        $log_stmt->execute();
    }

    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}

// รายการภาษาที่รองรับ
$supportedLangs = ['th', 'en'];

// ตรวจสอบการเปลี่ยนภาษาจาก URL
if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLangs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// กำหนดค่าภาษาเริ่มต้น หากยังไม่เคยเลือก
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// โหลดภาษา
$langCode = $_SESSION['lang'];
$langFile = __DIR__ . "/../lang/$langCode.php";
if (file_exists($langFile)) {
    require_once $langFile;
} else {
    // fallback ภาษาอังกฤษ
    require_once __DIR__ . "/../lang/en.php";
}
function buildLangSwitchLink($targetLang)
{
    $query = $_GET;
    $query['lang'] = $targetLang;
    return '?' . http_build_query($query);
}

// ถ้ามีการส่งฟอร์มมา
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bg'])) {
    $_SESSION['bg'] = $_POST['bg'] ?? '#ffffff';
    $_SESSION['bgside'] = $_POST['bgside'] ?? '#e9ecef';
    $_SESSION['text'] = $_POST['text'] ?? '#000000';
    $_SESSION['button'] = $_POST['button'] ?? '#007bff';
}

// ตั้งค่า default ถ้ายังไม่มีใน session
$bg = $_SESSION['bg'] ?? '#ffffff';
$bgside = $_SESSION['bgside'] ?? '#e9ecef';
$text = $_SESSION['text'] ?? '#000000';
$button = $_SESSION['button'] ?? '#007bff';