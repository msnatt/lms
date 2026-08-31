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
    <title><?= $lang['backup'] ?> - E-learning</title>

    <!-- Tailwind (scoped to backup.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        .bk-table {
            border-collapse: collapse;
            width: 100%;
            font-family: inherit;
        }

        .bk-table th {
            background: #f8fafc;
            color: #0c4a6e;
            text-transform: none;
            text-align: left;
            font-weight: 600;
            padding: .6rem .75rem;
            white-space: nowrap;
        }

        .bk-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
            vertical-align: middle;
        }

        .bk-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .bk-table tbody tr:hover {
            background: #f0f9ff;
        }

        .bk-panel .form-control:focus,
        .bk-modal .form-control:focus {
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
                <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
                    <button onclick="window.history.back();"
                        class="tw-inline-flex tw-items-center tw-justify-center tw-w-10 tw-h-10 tw-rounded-full tw-bg-white tw-shadow tw-text-brand tw-border-0 hover:tw-bg-slate-50 tw-transition">
                        <i class="bi bi-arrow-left tw-text-xl"></i>
                    </button>
                    <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0 tw-text-brandink">
                        <i class="bi bi-database-fill-down tw-text-brand"></i><?= $lang['backup'] ?>
                    </h2>
                    <span id="backup-total"
                        class="tw-text-sm tw-bg-sky-50 tw-text-brand tw-rounded-full tw-px-3 tw-py-0.5 tw-font-medium">0</span>
                </div>

                <!-- Summary cards -->
                <div class="tw-grid tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-4 tw-mb-6">
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center">
                        <div id="stat-count" class="tw-text-2xl tw-font-bold tw-text-brand">0</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['backupcount'] ?></div>
                    </div>
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center">
                        <div id="stat-size" class="tw-text-2xl tw-font-bold tw-text-brand">-</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['totalsize'] ?></div>
                    </div>
                    <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-text-center tw-col-span-2 lg:tw-col-span-1">
                        <div id="stat-latest" class="tw-text-lg tw-font-bold tw-text-brand">-</div>
                        <div class="tw-text-slate-500 tw-text-sm"><?= $lang['latestbackup'] ?></div>
                    </div>
                </div>

                <!-- Toolbar -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-mb-4 bk-panel">
                    <div class="tw-flex tw-flex-wrap tw-items-center tw-gap-2">
                        <button type="button" id="btn-export"
                            class="tw-bg-brand tw-text-white tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-border-0">
                            <i class="bi bi-download tw-mr-1"></i><?= $lang['export'] ?>
                        </button>
                        <button type="button" id="btn-import"
                            class="tw-bg-amber-50 tw-text-amber-700 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-amber-100">
                            <i class="bi bi-upload tw-mr-1"></i><?= $lang['import'] ?>
                        </button>
                        <button type="button" id="btn-refresh"
                            class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200 tw-ml-auto">
                            <i class="bi bi-arrow-clockwise tw-mr-1"></i><?= $lang['refresh'] ?>
                        </button>
                    </div>
                    <input type="file" id="sqlInput" class="d-none" accept=".sql">
                </div>

                <!-- Table -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                    <div id="table-wrap" class="tw-max-h-[55vh] tw-overflow-auto">
                        <table id="table_backup" class="bk-table">
                            <thead>
                                <tr>
                                    <th><?= $lang['filename'] ?></th>
                                    <th style="width: 120px;"><?= $lang['size'] ?></th>
                                    <th style="width: 170px;"><?= $lang['time'] ?></th>
                                    <th style="width: 150px;" class="tw-text-right"><?= $lang['action'] ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="empty-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                        <i class="bi bi-database tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0"><?= $lang['nobackup'] ?></p>
                    </div>
                    <div id="error-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-500">
                        <i class="bi bi-exclamation-triangle tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0 tw-mb-3"><?= $lang['loadfailed'] ?></p>
                        <button type="button" id="retry-btn"
                            class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2"><?= $lang['tryagain'] ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Delete confirm modal -->
    <div class="modal fade bk-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><?= $lang['confirmdelete'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="tw-m-0"><?= $lang['textconfirmdelete'] ?> <strong id="delete-file-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import confirm modal -->
    <div class="modal fade bk-modal" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel"><?= $lang['confirmimport'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tw-bg-red-50 tw-text-red-700 tw-rounded-lg tw-p-3 tw-text-sm tw-mb-3">
                        <i class="bi bi-exclamation-octagon-fill tw-mr-1"></i><?= $lang['importwarning'] ?>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="import-ack">
                        <label class="form-check-label" for="import-ack"><?= $lang['importack'] ?></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-import-btn" disabled><?= $lang['import'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-backup.html"; ?>
</body>

</html>
