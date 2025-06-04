<?php
include '../components/session.php';
?>


<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['resetpassword'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex justify-content-center align-items-center flex-column" style="width: 100vw; height: 90vh;">
        <div class="bg-white shadow rounded-2 p-4 w-100" style="max-width: 300px;">
            <h2 class="text-center mb-lg-5 mb-3"><?= $lang['resetpassword'] ?></h2>
            <p id="errortext" style='color:red;'></p>
            <label class="form-label fw-medium"><?= $lang['email'] ?></label>
            <input class="form-control rounded" type="text" name="email" id="email" required placeholder=<?= $lang['email'] ?>><br>
            <label class="form-label fw-medium"><?= $lang['password'] ?></label>
            <input class="form-control rounded" type="password" name="password" id="password" required placeholder=<?= $lang['password'] ?>><br>
            <label class="form-label fw-medium"><?= $lang['cpassword'] ?></label>
            <input class="form-control rounded" type="password" name="cpassword" id="cpassword" required placeholder=<?= $lang['cpassword'] ?>><br>
            <button class="btn btn-primary w-100" onclick="submit_resetpassword()" type="button"><?= $lang['confirm'] ?></button>

        </div>
    </div>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-resetpassword.html"; ?>
</body>

</html>