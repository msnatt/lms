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
    <title><?= $lang['result'] ?> - E-learning</title>

    <!-- Tailwind (scoped to results.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
            <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-py-8">

                <!-- Header -->
                <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
                    <button onclick="window.history.back();"
                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-rounded-full tw-bg-white tw-shadow tw-text-brand tw-border-0 hover:tw-bg-slate-50 tw-transition">
                        <i class="bi bi-arrow-left tw-text-xl"></i>
                    </button>
                    <div class="tw-min-w-0">
                        <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0 tw-text-brandink">
                            <i class="bi bi-mortarboard-fill tw-text-brand"></i><?= $lang['result'] ?>
                        </h2>
                        <p class="tw-text-slate-500 tw-m-0 tw-text-sm tw-truncate">
                            <?= htmlspecialchars(trim(($user['code'] ?? '') . ' - ' . ($user['name'] ?? '')), ENT_QUOTES) ?>
                        </p>
                    </div>
                </div>

                <!-- Summary stats -->
                <div id="summary" class="tw-grid tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-4 tw-mb-8">
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center">
                        <div id="stat-subjects" class="tw-text-2xl tw-font-bold tw-text-brand">0</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['subjectcount'] ?></div>
                    </div>
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center">
                        <div id="stat-exams" class="tw-text-2xl tw-font-bold tw-text-brand">0</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['examdone'] ?></div>
                    </div>
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center tw-col-span-2 lg:tw-col-span-1">
                        <div id="stat-avg" class="tw-text-2xl tw-font-bold tw-text-brand">0%</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['avgscore'] ?></div>
                    </div>
                </div>

                <!-- Course list (filled by include/scriptjs-results.html) -->
                <div id="course-list" class="tw-flex tw-flex-col tw-gap-6"></div>

                <!-- Empty state -->
                <div id="empty-state"
                    class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-16 tw-text-slate-400">
                    <i class="bi bi-clipboard-x tw-text-5xl tw-mb-3"></i>
                    <p class="tw-m-0"><?= $lang['noresult'] ?></p>
                </div>

            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-results.html"; ?>
</body>

</html>
