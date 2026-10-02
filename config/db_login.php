<?php
include '../config/connect.php';
include '../components/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // ไม่ escape รหัสผ่าน — password_verify() เทียบ hash ไม่ได้ใส่ลง SQL

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    $ok = false;
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // ตรวจสอบ password กับ hash ใน DB
        $ok = password_verify($password, $user['password']);
    }

    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    // prepared statement — $user_agent มาจาก header ของ client ห้ามต่อสตริงลง SQL
    $log_stmt = $conn->prepare("INSERT INTO log_login (user_id, username, action, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?)");

    if ($ok) {
        session_regenerate_id(true); // กัน session fixation

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user'] = $user;

        //log
        $user_id = $user['id'];
        $log_username = $user['username'];

        $login_action = 'login';
        $log_stmt->bind_param("issss", $user_id, $log_username, $login_action, $ip_address, $user_agent);
        $log_stmt->execute();
        log_action("[" . $log_username . "] Login successful.");

        header("Location: ../pages/home.php");
        exit;
    } else {
        // ครอบทั้งเคส "ไม่พบ username" และ "รหัสผ่านผิด" ด้วยข้อความเดียวกัน
        // เพื่อไม่เผยว่ามี username นี้อยู่จริงหรือไม่
        $failed_user_id = 0;
        $failed_action = 'login_failed';
        $log_stmt->bind_param("issss", $failed_user_id, $username, $failed_action, $ip_address, $user_agent);
        $log_stmt->execute();
        log_action("[" . $username . "] An unknown user attempted to access the account.");
        log_error("[" . $username . "] An unknown user attempted to access the account.");

        $_SESSION['login_error'] = $lang['loginfailed'];
        header("Location: ../pages/login.php");
        exit;
    }
}
