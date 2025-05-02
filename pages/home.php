<?php
include '../components/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="d-flex justify-content-center" style="min-height: 70vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div class="mt-4 " style="width: 100%; max-width: 1650px;">
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
            <!-- <div id="video-container" style="min-height: 100vh;">
            <video id="auto-play-video" width="100%" height="auto" controls>
                <source src="https://www.youtube.com/watch?v=IGtyATs2Fq0" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div> -->
            <br>
            <br>
            <br>
            <br>
            <div class="row justify-content-center">
                <div class="d-flex justify-content-center">
                    <img src="../assets/images/ft1.png">
                </div>
                <div class="text-center mb-4">
                    <h2 class="text-warning">Our <span class="text-dark">Product</span></h2>
                </div>

                <div class="card-container">
                    <button class="scroll-btn previous" id="scrollPrevious">&lt;</button>

                    <div class="scroll-content" id="scrollContent">
                        <!-- Cards อยู่ใน scroll-content -->
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 1">
                            <div class="card-body">
                                <h3 class="card-title">Product 01</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 2">
                            <div class="card-body">
                                <h3 class="card-title">Product 02</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 3">
                            <div class="card-body">
                                <h3 class="card-title">Product 03</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 4">
                            <div class="card-body">
                                <h3 class="card-title">Product 04</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 5">
                            <div class="card-body">
                                <h3 class="card-title">Product 05</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="..//assets//images//250x150.png" alt="Product 6">
                            <div class="card-body">
                                <h3 class="card-title">Product 06</h3>
                                <p class="card-text">Descriptions</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h3 class="card-title">view more</h3>
                            </div>
                        </div>
                    </div>

                    <button class="scroll-btn next" id="scrollNext">&gt;</button>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="d-flex justify-content-center">
                    <i class="bi bi-display " style="font-size: 4vw;"></i>
                </div>
                <div class="text-center mb-4">
                    <h2 class="text-warning">Video <span class="text-dark">Present</span></h2>
                </div>
            </div>
            <div id="video-container" style="text-align: center;">
                <div id="youtube-video" style="width: 100%; max-width: 50vw; height: 100%; max-height: 50vh; margin: 0 auto;"></div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-home.html"; ?>

</body>

</html>