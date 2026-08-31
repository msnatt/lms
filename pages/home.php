<?php
include '../components/session.php';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title><?= $lang['home'] ?> - E-learning</title>

    <!-- Tailwind (scoped to home.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
</head>


<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">

            <!-- SECTION 1: HERO -->
            <div id="carouselExample" class="carousel slide tw-relative" data-bs-ride="carousel" data-bs-interval="3000">

                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- Slides -->
                <div class="carousel-inner tw-h-[55vh] md:tw-h-[70vh]">
                    <div class="carousel-item active tw-h-full">
                        <img id="slide01" class="tw-w-full tw-h-full tw-object-cover" alt="Slide 1">
                    </div>
                    <div class="carousel-item tw-h-full">
                        <img id="slide02" class="tw-w-full tw-h-full tw-object-cover" alt="Slide 2">
                    </div>
                    <div class="carousel-item tw-h-full">
                        <img id="slide03" class="tw-w-full tw-h-full tw-object-cover" alt="Slide 3">
                    </div>

                    <!-- Overlay: sits above every slide, does not slide with them -->
                    <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-black/70 tw-via-black/30 tw-to-transparent tw-flex tw-items-end tw-pointer-events-none">
                        <div class="tw-p-6 md:tw-p-12 tw-text-white tw-max-w-2xl">
                            <h1 class="tw-text-2xl md:tw-text-4xl tw-font-bold tw-mb-2"><?= $lang['home_hero_title'] ?></h1>
                            <p class="tw-text-sm md:tw-text-lg tw-mb-4 tw-opacity-90"><?= $lang['home_hero_sub'] ?></p>
                            <div class="tw-flex tw-gap-3 tw-pointer-events-auto">
                                <a href="../pages/course_catalogue.php" class="tw-bg-brand tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-no-underline hover:tw-opacity-90">
                                    <?= $lang['allcourse'] ?>
                                </a>
                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <a href="../pages/login.php" class="tw-bg-white tw-text-brandink tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-no-underline hover:tw-opacity-90">
                                        <?= $lang['login'] ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
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

            <!-- SECTION 2: ICON STRIP -->
            <div class="tw-bg-slate-50 tw-py-10 md:tw-py-16">
                <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-text-center">
                    <h2 class="tw-text-xl md:tw-text-2xl tw-font-bold tw-mb-1"><?= $lang['home_why'] ?></h2>
                    <p class="tw-text-slate-500 tw-mb-8"><?= $lang['home_why_sub'] ?></p>
                    <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-4 lg:tw-grid-cols-8 tw-gap-6">
                        <div class="tw-flex tw-justify-center">
                            <img id="icon01" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon02" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon03" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon04" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon05" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon06" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon07" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                        <div class="tw-flex tw-justify-center">
                            <img id="icon08" class="tw-w-1/2 tw-mx-auto tw-object-contain tw-transition tw-duration-300 hover:tw-scale-110" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: FEATURED COURSES -->
            <div class="tw-py-10 md:tw-py-16">
                <div class="tw-max-w-6xl tw-mx-auto tw-px-4">
                    <div class="tw-flex tw-justify-between tw-items-center tw-mb-8">
                        <div>
                            <h2 class="tw-text-xl md:tw-text-2xl tw-font-bold tw-mb-1"><?= $lang['home_featured'] ?></h2>
                            <p class="tw-text-slate-500"><?= $lang['home_featured_sub'] ?></p>
                        </div>
                        <a href="../pages/course_catalogue.php" class="tw-text-brand tw-font-medium tw-no-underline tw-whitespace-nowrap">
                            <?= $lang['viewall'] ?> &rarr;
                        </a>
                    </div>
                    <div id="featured-courses" class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6">
                        <!-- filled by scriptjs-home.html -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        window.IS_LOGGED_IN = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
        window.LANG_NOCOURSE = <?= json_encode($lang['nocourse']) ?>;
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-home.html"; ?>

</body>


</html>
