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
    <title><?= $lang['ams'] ?> - E-learning</title>

    <!-- Tailwind (scoped to access_management.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        .ams-table {
            border-collapse: collapse;
            width: 100%;
        }

        .ams-table th {
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

        .ams-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
            vertical-align: middle;
        }

        .ams-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .ams-table tbody tr:hover {
            background: #f0f9ff;
        }

        .ams-panel .form-control:focus,
        .ams-panel .form-select:focus,
        .ams-modal .form-control:focus,
        .ams-modal .form-select:focus {
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
                        <i class="bi bi-shield-check tw-text-brand"></i><?= $lang['ams'] ?>
                    </h2>
                </div>

                <div class="tw-flex tw-flex-col tw-gap-4">

                    <!-- Filter -->
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 ams-panel">
                        <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-3">
                            <div>
                                <label for="select-course" class="form-label tw-text-sm tw-text-slate-600"><?= $lang['selectcourse'] ?></label>
                                <select id="select-course" class="form-select">
                                    <option value="">=== <?= $lang['select'] ?> <?= $lang['course'] ?> ===</option>
                                </select>
                            </div>
                            <div>
                                <label for="search-student" class="form-label tw-text-sm tw-text-slate-600"><?= $lang['searchstudent'] ?></label>
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

                    <!-- Table -->
                    <div id="student_list" class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                        <div id="table-wrap" class="tw-max-h-[55vh] tw-overflow-y-auto">
                            <table id="table_list_student" class="ams-table">
                                <thead>
                                    <tr>
                                        <th style="width: 44px;">
                                            <input type="checkbox" id="check-all" class="form-check-input tw-m-0">
                                        </th>
                                        <th style="width: 160px;"><?= $lang['code'] ?></th>
                                        <th><?= $lang['name'] ?></th>
                                        <th style="width: 140px;"><?= $lang['action'] ?></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="nocourse-state"
                            class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                            <i class="bi bi-journal-arrow-down tw-text-4xl tw-mb-2"></i>
                            <p class="tw-m-0"><?= $lang['pickcourse'] ?></p>
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

                    <!-- Actions -->
                    <div class="tw-flex tw-justify-end tw-gap-2">
                        <button type="button" id="btn-remove"
                            class="tw-bg-red-50 tw-text-red-600 tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-font-medium disabled:tw-bg-slate-100 disabled:tw-text-slate-400"
                            disabled>
                            <i class="bi bi-shield-minus tw-mr-1"></i><?= $lang['revoke'] ?> (<span id="remove-count">0</span>)
                        </button>
                        <button type="button" id="btn-add"
                            class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-5 tw-py-2 tw-font-medium disabled:tw-bg-slate-200 disabled:tw-text-slate-400"
                            disabled>
                            <i class="bi bi-shield-plus tw-mr-1"></i><?= $lang['access'] ?> (<span id="add-count">0</span>)
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Confirm modal -->
    <div class="modal fade ams-modal" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="tw-m-0" id="confirmModalText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" id="confirmModalBtn"><?= $lang['confirm'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-access-management.html"; ?>
</body>

</html>
