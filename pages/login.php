<?php
include '../components/session.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="../config/db_login.php" method="post">
        <label>Username: </label>
        <input type="text" name="username" required><br>
        <label>Password: </label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php include "../include/scriptjs.html"; ?>
</body>
</html>