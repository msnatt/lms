<?php
include '../components/session.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex justify-content-center align-items-center flex-column" style="width: 100vw; height: 90vh;">
        <div class="bg-white shadow rounded-2 p-4 w-100" style="max-width: 300px;">
            <h2 class="text-center mb-lg-5 mb-3">Login</h2>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form action="../config/db_login.php" method="post">
                <label class="form-label fw-medium">Username </label>
                <input class="form-control rounded" type="text" name="username" required placeholder="Enter username"><br>
                <label class="form-label fw-medium">Password: </label>
                <input class="form-control rounded" type="password" name="password" required placeholder="Your password"><br>
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>
        </div>
    </div>
    <?php include "../include/scriptjs.html"; ?>
</body>

</html>