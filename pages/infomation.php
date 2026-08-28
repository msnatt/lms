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
    <title><?= $lang['homecontentmanagement'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-house-gear"></i></span>
                    <h2><?= $lang['homecontentmanagement'] ?></h2>
                </div>

                <div class="result-stats" id="home-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-slides">3</div>
                            <div class="result-stat-label"><?= $lang['homeslides'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-icons">8</div>
                            <div class="result-stat-label"><?= $lang['homeicons'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-collection"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-images">0</div>
                            <div class="result-stat-label"><?= $lang['imagelibrary'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="toolbar">
                    <button type="button" id="manageimage" class="btn btn-outline-secondary position-static">
                        <i class="bi bi-images me-1"></i><?= $lang['manageimage'] ?>
                    </button>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-7">
                        <form id="form-homeprofile" action="../config/home-update.php" method="post">

                            <div class="panel mb-3">
                                <h3><span class="step-badge">1</span><?= $lang['homeslides'] ?></h3>
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold text-center d-block" for="select-slide01"><?= $lang['slide01'] ?></label>
                                        <img class="home-thumb mb-2" id="img_slide01" alt="">
                                        <select id="select-slide01" name="slide01" class="form-select form-select-sm"></select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold text-center d-block" for="select-slide02"><?= $lang['slide02'] ?></label>
                                        <img class="home-thumb mb-2" id="img_slide02" alt="">
                                        <select id="select-slide02" name="slide02" class="form-select form-select-sm"></select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold text-center d-block" for="select-slide03"><?= $lang['slide03'] ?></label>
                                        <img class="home-thumb mb-2" id="img_slide03" alt="">
                                        <select id="select-slide03" name="slide03" class="form-select form-select-sm"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="panel mb-3">
                                <h3><span class="step-badge">2</span><?= $lang['homeicons'] ?></h3>
                                <div class="row g-3">
                                    <?php for ($i = 1; $i <= 8; $i++):
                                        $key = 'icon' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label fw-semibold text-center d-block" for="select-<?= $key ?>"><?= $lang[$key] ?></label>
                                            <img class="home-thumb mb-2" id="img_<?= $key ?>" alt="">
                                            <select id="select-<?= $key ?>" name="<?= $key ?>" class="form-select form-select-sm"></select>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="panel mb-3">
                                <h3><span class="step-badge">3</span><?= $lang['homevideo'] ?></h3>
                                <label class="form-label" for="youtube_id">YouTube ID</label>
                                <div class="input-group">
                                    <span class="input-group-text">youtube.com/watch?v=</span>
                                    <input class="form-control" id="youtube_id" name="youtube_id" placeholder="dQw4w9WgXcQ">
                                </div>
                            </div>

                            <div class="panel-soft">
                                <h3><span class="step-badge">4</span><?= $lang['save'] ?></h3>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-floppy me-1"></i><?= $lang['save'] ?>
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="panel cert-preview">
                            <h3><i class="bi bi-youtube"></i><?= $lang['preview'] ?></h3>
                            <div class="cert-preview-frame">
                                <div id="youtube-video" style="width: 100%; aspect-ratio: 16 / 9;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="managebox" class="p-3">
                    <h3 class="text-center"><?= $lang['manageimage'] ?></h3>
                    <div id="preview" class="w-100 text-center" style="display: none;">
                        <p class="text-center mb-0 fw-bold"><?= $lang['preview'] ?></p>
                        <img id="img-preview" src="" alt="Image Preview" style="max-height: 200px;">
                    </div>
                    <button class="btn btn-success mx-auto my-2 w-25" id="btn-save" onclick="saveto()" style="display: none;"><?= $lang['save'] ?></button>
                    <div class="w-100 px-4 py-2">
                        <label for="imageInput" class="upload-box w-100">
                            <p class="mb-0"><?= $lang['clickforimport'] ?></p>
                            <input type="file" id="imageInput" accept="image/*" style="display: none;">
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-infomation.html"; ?>
</body>

</html>
