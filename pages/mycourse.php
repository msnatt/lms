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
    <title><?= $lang['mycourse'] ?> - E-learning</title>

    <!-- Tailwind (scoped to mycourse.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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

                <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
                    <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0">
                        <i class="bi bi-book-half tw-text-brand"></i><?= $lang['mycourse'] ?>
                    </h2>
                </div>

                <div class="tw-flex tw-flex-col tw-gap-6">

                    <!-- Filter bar (แนวนอน) -->
                    <details class="tw-bg-white tw-rounded-xl tw-shadow" open id="filter-box">
                        <summary class="tw-cursor-pointer tw-select-none tw-flex tw-items-center tw-gap-2 tw-font-bold tw-p-4 lg:tw-pointer-events-none">
                            <i class="bi bi-funnel-fill tw-text-brand"></i><?= $lang['filter'] ?>
                        </summary>
                        <div class="tw-px-4 tw-pb-4">
                            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-3">
                                <div>
                                    <label class="form-label"><?= $lang['codecourse'] ?></label>
                                    <input type="text" id="code_filter" name="code_filter" class="form-control" oninput="validateNumberInput(event)" placeholder="<?= $lang['entercode'] ?>">
                                </div>
                                <div>
                                    <label class="form-label"><?= $lang['namecourse'] ?></label>
                                    <input type="text" id="name_filter" name="name_filter" class="form-control" oninput="filterCourses()" placeholder="<?= $lang['entername'] ?>">
                                </div>
                                <div>
                                    <label class="form-label"><?= $lang['faculty'] ?></label>
                                    <select class="form-select" name="select_faculty" id="select_faculty" onchange="filterCourses()">
                                        <option value=""><?= $lang['all_faculty'] ?></option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label"><?= $lang['department'] ?></label>
                                    <select class="form-select" name="select_department" id="select_department" onchange="filterCourses()">
                                        <option value=""><?= $lang['all_department'] ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-end tw-mt-3">
                                <button type="button" onclick="clearFilters()" class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-4 tw-py-2 tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                    <i class="bi bi-x-circle"></i> <?= $lang['clearfilter'] ?>
                                </button>
                            </div>
                        </div>
                    </details>

                    <!-- Results -->
                    <div id="result-box" class="tw-min-w-0">
                        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                            <div class="tw-text-slate-600">
                                <?= $lang['numofresult'] ?> : <span id="numofresult" class="tw-font-bold tw-text-brand">0</span>
                            </div>
                            <button type="button" id="refresh-btn" class="tw-bg-white tw-border tw-border-slate-200 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm hover:tw-bg-slate-50">
                                <i class="bi bi-arrow-clockwise"></i> <?= $lang['refresh'] ?>
                            </button>
                        </div>

                        <div id="course_div" class="tw-grid tw-content-start tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-3 xl:tw-grid-cols-4 tw-gap-6" style="min-height: 40svh;"></div>

                        <!-- Pagination -->
                        <div class="tw-flex tw-items-center tw-justify-center tw-gap-4 tw-mt-8">
                            <button id="prev-page" class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 disabled:tw-bg-slate-200 disabled:tw-text-slate-400" disabled>
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <span class="tw-text-slate-600"><?= $lang['page'] ?> <span id="current-page" class="tw-font-bold tw-text-slate-900">1</span> / <span id="total-pages">1</span></span>
                            <button id="next-page" class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 disabled:tw-bg-slate-200 disabled:tw-text-slate-400">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>

                        <?php if (is_array($user) && ($user['is_admin'] ?? 0) == 1): ?>
                            <div style="position: fixed; bottom: 5%; right: 3%;">
                                <button class="tw-w-14 tw-h-14 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 tw-shadow-lg tw-text-2xl hover:tw-opacity-90" onclick="window.location.href = '../pages/course_create.php'">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-mycourse.html"; ?>
</body>

</html>
