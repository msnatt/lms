<?php
include '../components/session.php';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title><?= $lang['home'] ?> - E-learning</title>
</head>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100svh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="mt-4 flex-grow-1" style="transition: all 0.3s ease;">
            <div class="container bg-white w-100">
                
            </div>
        </div>
    </div>

    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-infomation.html"; ?>



</body>


</html>