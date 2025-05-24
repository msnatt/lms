<?php
include '../components/session.php';
?>


<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['login'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex justify-content-center align-items-center flex-column" style="width: 100vw; height: 90vh;">
        <div class="bg-white shadow rounded-2 p-4 w-100" style="max-width: 300px;">
            <h2 class="text-center mb-lg-5 mb-3"><?= $lang['register'] ?></h2>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <p class="pb-3" style="font-size: large;"><?=$lang['registertext']?></p>
            <button onclick="window.history.back();" class="btn btn-outline-secondary w-100 text text-black"><?=$lang['back']?></button>
        </div>
    </div>
    <?php include "../include/scriptjs.html"; ?>
</body>

</html>