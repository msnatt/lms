<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<head>
    <meta charset="UTF-8">
    <title><?=$lang['exam']?> - E-learning</title>
</head>

<body class="">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <!-- <div class="">
            <h3 class="p-4">FT - LMS</h3>
        </div> -->
        <div class="d-flex " style="min-height: 50vh;">
            <?php include "../components/sidemenu.php"; ?>

            <div class="d-flex flex-column justify-content-center align-items-center w-100 container">
                <div id="text-result" class="fs-2 text-dark text-center w-100 py-5"></div>
                <button class="btn btn-primary bg-opacity-25 rounded-2 border" onclick="window.location.href='home.php'"><?=$lang['returnH']?></button>
            </div>
        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-examinationed.html"; ?>
</body>

</html>