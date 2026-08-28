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
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="home-wrap">

                <?php include "../include/slidepage.php"; ?>

                <section class="home-section">
                    <div class="home-section-head">
                        <span class="home-eyebrow"><?= $lang['home'] ?></span>
                        <h2>Trusted <span class="text-primary">Partners</span></h2>
                    </div>
                    <div class="home-icon-grid">
                        <div class="home-icon-card"><img id="icon01" alt=""></div>
                        <div class="home-icon-card"><img id="icon02" alt=""></div>
                        <div class="home-icon-card"><img id="icon03" alt=""></div>
                        <div class="home-icon-card"><img id="icon04" alt=""></div>
                        <div class="home-icon-card"><img id="icon05" alt=""></div>
                        <div class="home-icon-card"><img id="icon06" alt=""></div>
                        <div class="home-icon-card"><img id="icon07" alt=""></div>
                        <div class="home-icon-card"><img id="icon08" alt=""></div>
                    </div>
                </section>

                <section class="home-section">
                    <div class="home-section-head">
                        <i class="bi bi-display home-section-icon"></i>
                        <span class="home-eyebrow">Media</span>
                        <h2>Video <span class="text-primary">Present</span></h2>
                    </div>
                    <div class="home-video-card">
                        <div id="youtube-video" class="home-video-frame"></div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-home.html"; ?>

</body>


</html>
