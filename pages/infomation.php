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
        <div id="main-content" class="mt-4 flex-grow-1 d-flex justify-content-center" style="transition: all 0.3s ease;">
            <div id="managebox" class="bg-white rounded p-3">
                <h3 class="text-center"><?=$lang['manageimage']?></h3>
                <div id="preview" class="w-100 text-center" style="display: none;">
                    <p class="text-center mb-0 fw-bold"><?= $lang['preview'] ?></p>
                    <img id="img-preview" src="#" alt="Image Preview" style="max-height: 200px;">
                </div>
                <button class="btn btn-success mx-auto my-2 w-25" id="btn-save" onclick="saveto()" style="display: none;"><?= $lang['save'] ?></button>
                <div class="w-100 px-4 py-2">
                    <label for="imageInput" class="upload-box w-100">
                        <p><?=$lang['clickforimport']?></p>
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    </label>
                </div>
            </div>
            <form id="form-homeprofile" action="../config/home-update.php" method="post">
                <div class="d-flex gap-3 justify-content-center">
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['slide01'] ?></label>
                        <img class="w-100 rounded" id="img_slide01">
                        <select id="select-slide01" name="slide01" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['slide02'] ?></label>
                        <img class="w-100 rounded" id="img_slide02">
                        <select id="select-slide02" name="slide02" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['slide03'] ?></label>
                        <img class="w-100 rounded" id="img_slide03">
                        <select id="select-slide03" name="slide03" class="form-select"></select>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3 my-3 container">
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon01'] ?></label>
                        <img class="w-100 rounded" id="img_icon01">
                        <select id="select-icon01" name="icon01" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon02'] ?></label>
                        <img class="w-100 rounded" id="img_icon02">
                        <select id="select-icon02" name="icon02" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon03'] ?></label>
                        <img class="w-100 rounded" id="img_icon03">
                        <select id="select-icon03" name="icon03" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon04'] ?></label>
                        <img class="w-100 rounded" id="img_icon04">
                        <select id="select-icon04" name="icon04" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon05'] ?></label>
                        <img class="w-100 rounded" id="img_icon05">
                        <select id="select-icon05" name="icon05" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon06'] ?></label>
                        <img class="w-100 rounded" id="img_icon06">
                        <select id="select-icon06" name="icon06" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon07'] ?></label>
                        <img class="w-100 rounded" id="img_icon07">
                        <select id="select-icon07" name="icon07" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon08'] ?></label>
                        <img class="w-100 rounded" id="img_icon08">
                        <select id="select-icon08" name="icon08" class="form-select"></select>
                    </div>
                    <div class="d-flex flex-column boxsq bg-white p-3 rounded gap-2">
                        <label class="form-label text text-center fs-3"><?= $lang['icon09'] ?></label>
                        <img class="w-100 rounded" id="img_icon09">
                        <select id="select-icon09" name="icon09" class="form-select"></select>
                    </div>
                </div>
                <input type="hidden" id="youtube_id" name="youtube_id">
                <div id="video-container mb-4" style="text-align: center;">
                    <div id="youtube-video" style="width: 100%; max-width: 50vw; height: 100%; max-height: 50vh; margin: 0 auto;"></div>
                </div>
                <button type="submit" class="rounded-circle bg-white shadow p-3 px-4 border-0" style="position: fixed; bottom: 5%; right: 5%;">
                    <i class="bi bi-floppy fs-3"></i>
                </button>
            </form>
            <button id="manageimage" class="rounded-circle bg-white shadow p-3 px-4 border-0" style="position: fixed; bottom: 5%; right: 10%;">
                <i class="bi bi-house-gear fs-3"></i>
            </button>
        </div>
    </div>

    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-infomation.html"; ?>



</body>


</html>