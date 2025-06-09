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
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="mt-4 flex-grow-1" style="transition: all 0.3s ease;">
            <div class="d-flex justify-content-center py-4">
                <?php include "../include/slidepage.php"; ?>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center" >
                <div class="row justify-content-center" style="max-width: 1600px;">
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon01.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon02.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon03.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon04.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon05.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon06.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon07.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon08.png" class="d-block w-auto">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img src="../assets/images/icon09.png" class="d-block w-auto">
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>


            <div class="row justify-content-center">
                <div class="d-flex justify-content-center">
                    <i class="bi bi-display " style="font-size: 4vw;"></i>
                </div>
                <div class="text-center mb-4">
                    <h2 class="text-warning">Video <span class="text-dark">Present</span></h2>
                </div>
            </div>
            <div id="video-container mb-4" style="text-align: center;">
                <div id="youtube-video" style="width: 100%; max-width: 50vw; height: 100%; max-height: 50vh; margin: 0 auto;"></div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-home.html"; ?>



</body>


</html>