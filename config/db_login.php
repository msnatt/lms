<?php
include '../config/connect.php';
include '../components/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    // $result = $conn->query($sql);
    // ดึงข้อมูลจาก username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // ตรวจสอบ password กับ hash ใน DB
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user'] = $user;

            //log
            $user_id = $user['id'];
            $username = $user['username'];
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $log_sql = "INSERT INTO log_login (user_id, username, action, ip_address, user_agent) 
            VALUES ('$user_id', '$username', 'login', '$ip_address', '$user_agent')";
            $conn->query($log_sql);
            log_action("[" . $username . "] Login successful.");

            header("Location: ../pages/home.php");
        }
    }
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $log_sql = "INSERT INTO log_login (user_id, username, action, ip_address, user_agent) 
            VALUES (0, '$username', 'login_failed', '$ip_address', '$user_agent')";
    $conn->query($log_sql);
    log_action($username . "An unknown user attempted to access the account.");
    log_error($username . "An unknown user attempted to access the account.");
    echo "<script>alert('Invalid username or password!'); window.location.href='../pages/login.php';</script>";
}
