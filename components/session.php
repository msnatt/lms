<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.php");
        exit();
    }
}

function logout() {
    // Logging logout
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        include '../config/connect.php'; // อย่าลืมเชื่อมต่อ DB

        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $log_sql = "INSERT INTO login_log (user_id, username, action, ip_address, user_agent) 
                    VALUES ('$user_id', '$username', 'logout', '$ip_address', '$user_agent')";
        $conn->query($log_sql);
    }

    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}
?>
