<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['catalogue'] ?> - E-learning</title>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="bg-light p-4 w-100" style="min-height: 60vh; ">
                <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                <span id="title_edit" style="font-size: 2rem; font-weight: 600;"><?= $lang['catalogue'] ?></span>
                <div id="catalogue_div" class="bg-white d-flex container gap-2 " style="min-height:50%;
                ">

                </div>
            </div>
        </div>
    </div>



    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course_catalogue.html"; ?>
</body>

</html>