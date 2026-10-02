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
    <title><?= $lang['certificate'] ?> - E-learning</title>

    <!-- Tailwind (scoped to certificate.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        /* Page-scoped overrides — beat the global bare-table + orange-focus rules in include/style.html */
        .cert-table {
            border-collapse: collapse;
            width: 100%;
        }

        .cert-table th {
            background: #f8fafc;
            color: #0c4a6e;
            text-transform: none;
            text-align: left;
            font-weight: 600;
            padding: .6rem .75rem;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .cert-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
        }

        .cert-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .cert-table tbody tr:hover {
            background: #f0f9ff;
        }

        .cert-panel .form-control:focus,
        .cert-panel .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-py-8">

                <!-- Header -->
                <div class="tw-mb-6">
                    <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0 tw-text-brandink">
                        <i class="bi bi-award-fill tw-text-brand"></i><?= $lang['certificatemanagement'] ?>
                    </h2>
                </div>

                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-6">

                    <!-- LEFT: filters + student picker + export -->
                    <div class="lg:tw-col-span-2 tw-flex tw-flex-col tw-gap-4 cert-panel">

                        <!-- Filter card -->
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4">
                            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-3">
                                <div>
                                    <label class="form-label tw-text-sm tw-text-slate-600 tw-mb-1"><?= $lang['selectcourse'] ?></label>
                                    <select id="select-course" class="form-select">
                                        <option value="">=== <?= $lang['allcourses'] ?> ===</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label tw-text-sm tw-text-slate-600 tw-mb-1"><?= $lang['template'] ?></label>
                                    <select id="select-template" class="form-select" required>
                                        <option value="">=== <?= $lang['templateblank'] ?> ===</option>
                                    </select>
                                </div>
                                <div class="sm:tw-col-span-2">
                                    <label class="form-label tw-text-sm tw-text-slate-600 tw-mb-1"><?= $lang['searchstudent'] ?></label>
                                    <div class="tw-relative">
                                        <i class="bi bi-search tw-absolute tw-left-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-slate-400"></i>
                                        <input id="search-student" type="text" class="form-control tw-pl-9" placeholder="<?= $lang['searchstudent'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selected chips -->
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4">
                            <div class="tw-flex tw-items-center tw-justify-between tw-mb-2">
                                <span class="tw-text-sm tw-font-semibold tw-text-slate-700">
                                    <?= $lang['selectedcount'] ?>: <span id="selected-count">0</span>
                                </span>
                                <button type="button" id="clear-selected"
                                    class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                    <?= $lang['clearselected'] ?>
                                </button>
                            </div>
                            <div id="select-list" class="tw-flex tw-flex-wrap tw-gap-2 tw-min-h-[2rem]"></div>
                        </div>

                        <!-- Student table -->
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                            <div id="student_list" class="tw-max-h-[60vh] tw-overflow-y-auto">
                                <table id="table_list_student" class="cert-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 44px;">
                                                <input type="checkbox" id="check-all" class="form-check-input tw-m-0">
                                            </th>
                                            <th style="width: 160px;"><?= $lang['code'] ?></th>
                                            <th><?= $lang['name'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div id="empty-state"
                                class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                                <i class="bi bi-people tw-text-4xl tw-mb-2"></i>
                                <p class="tw-m-0"><?= $lang['nostudent'] ?></p>
                            </div>
                            <div id="error-state"
                                class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-500">
                                <i class="bi bi-exclamation-triangle tw-text-4xl tw-mb-2"></i>
                                <p class="tw-m-0 tw-mb-3"><?= $lang['loadfailed'] ?></p>
                                <button type="button" id="retry-btn"
                                    class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2"><?= $lang['tryagain'] ?></button>
                            </div>
                        </div>

                        <!-- Export bar -->
                        <div class="tw-flex tw-justify-end">
                            <button type="button" id="export-btn"
                                class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-5 tw-py-2 tw-font-medium disabled:tw-bg-slate-200 disabled:tw-text-slate-400"
                                disabled>
                                <i class="bi bi-download tw-mr-1"></i><?= $lang['export'] ?> (<span id="export-count">0</span>)
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT: template preview -->
                    <div class="lg:tw-col-span-1">
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 lg:tw-sticky lg:tw-top-4">
                            <h4 class="tw-text-base tw-font-bold tw-text-slate-700 tw-mb-3"><?= $lang['pretemplate'] ?></h4>
                            <img id="image-Show" src="../assets/images/default-template.png"
                                class="tw-w-full tw-rounded-lg tw-border tw-border-solid tw-border-slate-200" alt="template preview" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-certificate.html"; ?>
</body>

</html>
