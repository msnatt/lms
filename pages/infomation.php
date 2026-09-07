<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? [];
if (!is_array($user) || ($user['is_admin'] ?? 0) != 1) {
    header("Location: ../pages/home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['information'] ?> - E-learning</title>

    <!-- Tailwind (scoped to infomation.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        brand: '#0284c7',
                        brandink: '#0c4a6e'
                    }
                }
            }
        }
    </script>
    <style>
        /* input:focus ของ style.html ยังเป็นขอบส้มเดิม (ใช้ร่วมทั้งระบบ) ทับด้วยสีฟ้าของแบรนด์ใหม่เฉพาะหน้านี้ */
        #form-homeprofile .form-control:focus,
        #form-homeprofile .form-select:focus,
        #managebox .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100svh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">

            <form id="form-homeprofile" action="../config/home-update.php" method="post">

                <!-- ACTION BAR -->
                <div class="tw-sticky tw-top-0 tw-z-20 tw-bg-white tw-border-b tw-border-slate-200 tw-shadow-sm">
                    <div class="tw-w-full tw-px-4 lg:tw-px-8 tw-py-3 tw-flex tw-items-center tw-justify-between tw-gap-3">
                        <div class="tw-flex tw-items-center tw-gap-2 tw-min-w-0">
                            <i class="bi bi-house-gear tw-text-xl tw-text-brand"></i>
                            <div class="tw-text-lg md:tw-text-xl tw-font-bold tw-text-brandink tw-truncate"><?= $lang['information'] ?></div>
                        </div>
                        <div class="tw-flex tw-items-center tw-gap-2 tw-shrink-0">
                            <button type="button" id="manageimage" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-white hover:tw-bg-slate-50 tw-text-slate-600 tw-border tw-border-slate-300 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium">
                                <i class="bi bi-images"></i> <span class="tw-hidden sm:tw-inline"><?= $lang['manageimage'] ?></span>
                            </button>
                            <button type="submit" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-brand hover:tw-opacity-90 tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium">
                                <i class="bi bi-floppy-fill"></i> <span class="tw-hidden sm:tw-inline"><?= $lang['save'] ?></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="tw-w-full tw-px-4 lg:tw-px-8 tw-py-6 tw-flex tw-flex-col tw-gap-8">

                    <!-- HERO SLIDES -->
                    <section>
                        <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-3">
                            <i class="bi bi-images"></i> <?= $lang['homeslides'] ?>
                        </h2>
                        <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-3 tw-gap-4">
                            <?php for ($i = 1; $i <= 3; $i++): $k = sprintf('slide%02d', $i); ?>
                                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-flex tw-flex-col tw-gap-2">
                                    <label class="tw-text-sm tw-font-semibold tw-text-slate-600 tw-text-center"><?= $lang[$k] ?></label>
                                    <img class="tw-w-full tw-aspect-video tw-object-cover tw-rounded-lg tw-bg-slate-100" id="img_<?= $k ?>" alt="">
                                    <select id="select-<?= $k ?>" name="<?= $k ?>" class="form-select"></select>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </section>

                    <!-- FEATURE ICONS -->
                    <section>
                        <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-3">
                            <i class="bi bi-grid-3x3-gap"></i> <?= $lang['homeicons'] ?>
                        </h2>
                        <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-3 lg:tw-grid-cols-4 tw-gap-4">
                            <?php for ($i = 1; $i <= 8; $i++): $k = sprintf('icon%02d', $i); ?>
                                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-flex tw-flex-col tw-gap-2">
                                    <label class="tw-text-sm tw-font-semibold tw-text-slate-600 tw-text-center"><?= $lang[$k] ?></label>
                                    <img class="tw-w-full tw-aspect-square tw-object-contain tw-rounded-lg tw-bg-slate-100 tw-p-2" id="img_<?= $k ?>" alt="">
                                    <select id="select-<?= $k ?>" name="<?= $k ?>" class="form-select"></select>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </section>

                    <!-- INTRO VIDEO -->
                    <section>
                        <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-3">
                            <i class="bi bi-youtube"></i> <?= $lang['homevideo'] ?>
                        </h2>
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-flex tw-flex-col tw-gap-3 tw-max-w-2xl">
                            <label class="tw-text-sm tw-font-semibold tw-text-slate-600">YouTube ID</label>
                            <div class="tw-flex tw-items-center tw-rounded-lg tw-border tw-border-slate-300 tw-overflow-hidden focus-within:tw-border-brand">
                                <span class="tw-px-3 tw-py-2 tw-bg-slate-100 tw-text-slate-500 tw-text-sm tw-whitespace-nowrap">youtube.com/watch?v=</span>
                                <input class="form-control tw-border-0 tw-rounded-none" id="youtube_id" name="youtube_id">
                            </div>
                            <div class="video-container mb-4" style="text-align: center;">
                                <div id="youtube-video" style="width: 100%; max-width: 50vw; height: 100%; max-height: 50vh; margin: 0 auto;"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>

    <!-- Image manager (fixed slide-in panel, controlled by #manageimage via style.html's #managebox.show) -->
    <div id="managebox" class="bg-white rounded p-3">
        <h3 class="text-center"><?= $lang['manageimage'] ?></h3>
        <div id="preview" class="w-100 text-center" style="display: none;">
            <p class="text-center mb-0 fw-bold"><?= $lang['preview'] ?></p>
            <img id="img-preview" src="#" alt="Image Preview" style="max-height: 200px;">
        </div>
        <button class="btn btn-success mx-auto my-2 w-25" id="btn-save" onclick="saveto()" style="display: none;"><?= $lang['save'] ?></button>
        <div class="w-100 px-4 py-2">
            <label for="imageInput" class="upload-box w-100">
                <p><?= $lang['clickforimport'] ?></p>
                <input type="file" id="imageInput" accept="image/*" style="display: none;">
            </label>
        </div>
    </div>

    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-infomation.html"; ?>

</body>

</html>
