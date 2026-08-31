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
    <title><?= $lang['logs'] ?> - E-learning</title>

    <!-- Tailwind (scoped to log.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        .log-table {
            border-collapse: collapse;
            width: 100%;
            font-family: inherit;
        }

        .log-table th {
            background: #f8fafc;
            color: #0c4a6e;
            text-transform: none;
            text-align: left;
            font-weight: 600;
            padding: .6rem .75rem;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .log-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
            vertical-align: top;
        }

        .log-table td.msg {
            white-space: pre-wrap;
            word-break: break-word;
            max-width: 0;
        }

        .log-table td.ua {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .log-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .log-table tbody tr:hover {
            background: #f0f9ff;
        }

        .log-panel .form-control:focus,
        .log-panel .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }

        .log-tab.active {
            background: #0284c7;
            color: #fff;
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
                <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
                    <button onclick="window.history.back();"
                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-rounded-full tw-bg-white tw-shadow tw-text-brand tw-border-0 hover:tw-bg-slate-50 tw-transition">
                        <i class="bi bi-arrow-left tw-text-xl"></i>
                    </button>
                    <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0 tw-text-brandink">
                        <i class="bi bi-journal-text tw-text-brand"></i><?= $lang['logs'] ?>
                    </h2>
                    <span id="log-total"
                        class="tw-text-sm tw-bg-sky-50 tw-text-brand tw-rounded-full tw-px-3 tw-py-0.5 tw-font-medium">0</span>
                </div>

                <!-- Toolbar -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-mb-4 log-panel">
                    <div class="tw-flex tw-flex-wrap tw-items-center tw-gap-2">
                        <div class="tw-flex tw-gap-1">
                            <button type="button" data-type="login"
                                class="log-tab active tw-border-0 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-bg-slate-100 tw-text-slate-600">
                                <?= $lang['logins'] ?>
                            </button>
                            <button type="button" data-type="error"
                                class="log-tab tw-border-0 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-bg-slate-100 tw-text-slate-600">
                                <?= $lang['error'] ?>
                            </button>
                            <button type="button" data-type="action"
                                class="log-tab tw-border-0 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-bg-slate-100 tw-text-slate-600">
                                <?= $lang['logactiontab'] ?>
                            </button>
                        </div>
                        <div class="tw-flex tw-items-center tw-gap-2 tw-ml-auto">
                            <label for="per-page" class="tw-text-sm tw-text-slate-500 tw-m-0"><?= $lang['perpage'] ?></label>
                            <select id="per-page" class="form-select form-select-sm" style="width:auto;">
                                <option value="25">25</option>
                                <option value="50" selected>50</option>
                                <option value="100">100</option>
                            </select>
                            <button type="button" id="btn-refresh"
                                class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                <i class="bi bi-arrow-clockwise tw-mr-1"></i><?= $lang['refresh'] ?>
                            </button>
                            <button type="button" id="btn-export"
                                class="tw-bg-brand tw-text-white tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-border-0">
                                <i class="bi bi-download tw-mr-1"></i><?= $lang['export'] ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                    <div id="table-wrap" class="tw-max-h-[62vh] tw-overflow-auto">
                        <table id="table_log" class="log-table">
                            <thead>
                                <tr>
                                    <th style="width: 160px;"><?= $lang['time'] ?></th>
                                    <th style="width: 140px;"><?= $lang['username'] ?></th>
                                    <th style="width: 130px;"><?= $lang['category'] ?></th>
                                    <th><?= $lang['detail'] ?></th>
                                    <th style="width: 120px;"><?= $lang['ipaddress'] ?></th>
                                    <th style="width: 220px;"><?= $lang['useragent'] ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="empty-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                        <i class="bi bi-journal-x tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0"><?= $lang['nolog'] ?></p>
                    </div>
                    <div id="error-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-500">
                        <i class="bi bi-exclamation-triangle tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0 tw-mb-3"><?= $lang['loadfailed'] ?></p>
                        <button type="button" id="retry-btn"
                            class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2"><?= $lang['tryagain'] ?></button>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="tw-flex tw-items-center tw-justify-center tw-gap-4 tw-mt-6">
                    <button id="prev-page"
                        class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 disabled:tw-bg-slate-200 disabled:tw-text-slate-400"
                        disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <span class="tw-text-slate-600"><?= $lang['page'] ?> <span id="current-page"
                            class="tw-font-bold tw-text-slate-900">1</span> / <span id="total-pages">1</span></span>
                    <button id="next-page"
                        class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 disabled:tw-bg-slate-200 disabled:tw-text-slate-400">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-logs.html"; ?>
</body>

</html>
