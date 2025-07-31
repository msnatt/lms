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
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $log_sql = "INSERT INTO log_login (user_id, username, action, ip_address, user_agent) 
                    VALUES ('$user_id', '$username', 'logout', '$ip_address', '$user_agent')";

        $conn->query($log_sql);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['bg'] = $_POST['bg'] ?? '#ffffff';
    $_SESSION['bgbar'] = $_POST['bgbar'] ?? '#f8f9fa';
    $_SESSION['bgside'] = $_POST['bgside'] ?? '#e9ecef';
    $_SESSION['text'] = $_POST['text'] ?? '#000000';
    $_SESSION['button'] = $_POST['button'] ?? '#007bff';
}

// ตั้งค่า default ถ้ายังไม่มีใน session
$bg = $_SESSION['bg'] ?? '#ffffff';
$bgbar = $_SESSION['bgbar'] ?? '#f8f9fa';
$bgside = $_SESSION['bgside'] ?? '#e9ecef';
$text = $_SESSION['text'] ?? '#000000';
$button = $_SESSION['button'] ?? '#007bff';