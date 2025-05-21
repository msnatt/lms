<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">
<style>
    body {
        font-family: sans-serif;
        background: #f0f0f0;
    }

    .container {
        display: flex;
        gap: 2rem;
        max-width: 1000px;
        margin: auto;
    }

    .card {
        flex: 1;
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-top: 0;
    }

    label {
        font-weight: bold;
        display: block;
        margin-top: 1rem;
    }

    .form-custom {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        color: white;
        margin-top: 1rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background: #0056b3;
    }

    .result {
        margin-top: 10px;
        font-weight: bold;
        color: green;
    }
</style>

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<head>
    <meta charset="UTF-8">
    <title>Email Notifier - E-learning</title>
</head>

<body class="">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100" style="min-height: 70vh;">
                <h1 style="text-align:center">ระบบส่งข้อความ <br>LINE และ Email</h1>

                <div class="container gap-5 d-flex flex-wrap justify-content-center">
                    <!-- LINE Notify Form -->
                    <div class="row col-12 col-lg-4 rounded shadow" style="background-color: #4CAF50;">
                        <h2 class="py-3 px-4 text-white">LINE </h2>
                        <form id="lineForm" class="px-4 bg-white">
                            <label for="line_token">LINE Token:</label>
                            <input class="form-custom" type="text" id="line_token" name="line_token" required>

                            <label for="line_message">ข้อความทดสอบ:</label>
                            <textarea class="form-custom" id="line_message" name="line_message" required></textarea>

                            <button class="form-custom" type="submit" style="background-color: #4CAF50;">ส่งไปยัง LINE</button>
                            <div class="result" id="line_result"></div>
                        </form>
                    </div>

                    <!-- Email Form -->
                    <div class="row col-12 col-lg-4 rounded shadow" style="background-color: #b23121;">
                        <h2 class="py-3 px-4 text-white">Email</h2>
                        <form id="emailForm" class="px-4 bg-white">
                            <label for="email_to">Email ผู้รับ:</label>
                            <input class="form-custom" type="email" id="email_to" name="email_to" required>

                            <label for="email_message">ข้อความทดสอบ:</label>
                            <textarea class="form-custom" id="email_message" name="email_message" required></textarea>

                            <button class="form-custom" type="submit" style="background-color: #b23121;">ส่งอีเมล</button>
                            <div class="result" id="email_result"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-email.html"; ?>
</body>

</html>