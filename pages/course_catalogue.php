<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? [];
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['catalogue'] ?> - E-learning</title>

    <!-- Tailwind (scoped to course_catalogue.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
            <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-py-8">
                <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
                    <button onclick="window.history.back();" class="tw-bg-white tw-border tw-border-slate-200 tw-rounded-lg tw-w-10 tw-h-10 hover:tw-bg-slate-50">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <h2 class="tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0"><?= $lang['catalogue'] ?></h2>
                </div>

                <div id="catalogue_div" class="tw-flex tw-flex-col tw-gap-3"></div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course_catalogue.html"; ?>
</body>

</html>
