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


<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="mt-4 flex-grow-1" style="transition: all 0.3s ease;">
            <div class="d-flex justify-content-center py-4">
                <div class="main-inner" style="width: 85%;">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>

                        <!-- Slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img id="slide01" class="d-block w-100" style="max-width: 1920px; max-height: 75vh;" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img id="slide02" class="d-block w-100" style="max-width: 1920px; max-height: 75vh;" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img id="slide03" class="d-block w-100" style="max-width: 1920px; max-height: 75vh;" alt="Slide 3">
                            </div>
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <br>
                    <br>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="row justify-content-center" style="max-width: 1600px;">
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon01" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon02" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon03" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon04" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon05" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon06" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon07" class="d-block object-fit-contain w-50">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                        <img id="icon08" class="d-block object-fit-contain w-50">
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