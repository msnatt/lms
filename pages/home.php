<?php
include '../components/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="mt-4 flex-grow-1" style="transition: all 0.3s ease;">
            <div class="d-flex justify-content-center py-4">
                <?php include "../include/slidepage.php"; ?>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block">
                <br>
                <br>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row ">
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <img src="../assets/images/300100.png" class="d-block w-auto">
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