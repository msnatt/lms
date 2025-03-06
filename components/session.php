<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.php");
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}
?>
