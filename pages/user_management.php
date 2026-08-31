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
    <title><?= $lang['ums'] ?> - E-learning</title>

    <!-- Tailwind (scoped to user_management.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        .ums-table {
            border-collapse: collapse;
            width: 100%;
        }

        .ums-table th {
            background: #f8fafc;
            color: #0c4a6e;
            text-transform: none;
            text-align: left;
            font-weight: 600;
            padding: .6rem .75rem;
            white-space: nowrap;
        }

        .ums-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
            vertical-align: middle;
        }

        .ums-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .ums-table tbody tr:hover {
            background: #f0f9ff;
        }

        .ums-panel .form-control:focus,
        .ums-panel .form-select:focus,
        .ums-modal .form-control:focus,
        .ums-modal .form-select:focus {
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
                <div class="tw-mb-6 tw-flex tw-items-center tw-gap-2">
                    <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-xl md:tw-text-2xl tw-font-bold tw-m-0 tw-text-brandink">
                        <i class="bi bi-people-fill tw-text-brand"></i><?= $lang['ums'] ?>
                    </h2>
                    <span id="user-total"
                        class="tw-text-sm tw-bg-sky-50 tw-text-brand tw-rounded-full tw-px-3 tw-py-0.5 tw-font-medium">0</span>
                </div>

                <!-- Toolbar -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-mb-4 ums-panel">
                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-3">
                        <div class="lg:tw-col-span-2">
                            <div class="tw-relative">
                                <i class="bi bi-search tw-absolute tw-left-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-slate-400"></i>
                                <input id="search-user" type="text" class="form-control tw-pl-9"
                                    placeholder="<?= $lang['searchuser'] ?>">
                            </div>
                        </div>
                        <div>
                            <select id="filter-role" class="form-select">
                                <option value=""><?= $lang['allroles'] ?></option>
                                <option value="1"><?= $lang['roleadmin'] ?></option>
                                <option value="0"><?= $lang['rolestudent'] ?></option>
                            </select>
                        </div>
                        <div class="tw-flex tw-gap-2 tw-justify-end">
                            <button type="button" id="btn-import"
                                class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                <i class="bi bi-upload tw-mr-1"></i><?= $lang['import'] ?>
                            </button>
                            <button type="button" id="btn-export"
                                class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                <i class="bi bi-download tw-mr-1"></i><?= $lang['export'] ?>
                            </button>
                        </div>
                    </div>
                    <div class="tw-mt-3">
                        <button type="button" id="btn-add-user"
                            class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-font-medium">
                            <i class="bi bi-person-plus tw-mr-1"></i><?= $lang['adduser'] ?>
                        </button>
                    </div>
                    <input type="file" id="csvInput" class="d-none" accept=".csv">
                </div>

                <!-- Table -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                    <div id="table-wrap" class="tw-overflow-x-auto">
                        <table id="table_user" class="ums-table">
                            <thead>
                                <tr>
                                    <th><?= $lang['name'] ?></th>
                                    <th><?= $lang['code'] ?></th>
                                    <th><?= $lang['username'] ?></th>
                                    <th><?= $lang['email'] ?></th>
                                    <th><?= $lang['tel'] ?></th>
                                    <th><?= $lang['roles'] ?></th>
                                    <th class="tw-text-right"><?= $lang['action'] ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="empty-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                        <i class="bi bi-people tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0"><?= $lang['nouser'] ?></p>
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

    <!-- Add / Edit user modal -->
    <div class="modal fade ums-modal" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel"><?= $lang['adduser'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="f-userId">
                        <div class="mb-2">
                            <label for="f-name" class="form-label"><?= $lang['name'] ?></label>
                            <input type="text" class="form-control" id="f-name" maxlength="50" required>
                        </div>
                        <div class="mb-2">
                            <label for="f-code" class="form-label"><?= $lang['code'] ?></label>
                            <input type="text" class="form-control" id="f-code" maxlength="11" required>
                        </div>
                        <div class="mb-2">
                            <label for="f-username" class="form-label"><?= $lang['username'] ?></label>
                            <input type="text" class="form-control" id="f-username" maxlength="20" required>
                        </div>
                        <div class="mb-2">
                            <label for="f-email" class="form-label"><?= $lang['email'] ?></label>
                            <input type="email" class="form-control" id="f-email" maxlength="50" required>
                        </div>
                        <div class="mb-2">
                            <label for="f-telephone" class="form-label"><?= $lang['tel'] ?></label>
                            <input type="text" class="form-control" id="f-telephone" maxlength="10" required>
                        </div>
                        <div class="mb-2" id="f-password-wrap">
                            <label for="f-password" class="form-label"><?= $lang['newpassword'] ?></label>
                            <input type="password" class="form-control" id="f-password">
                        </div>
                        <div class="mb-2 form-check" id="f-isadmin-wrap">
                            <input type="checkbox" class="form-check-input" id="f-is_admin">
                            <label for="f-is_admin" class="form-check-label"><?= $lang['roleadmin'] ?></label>
                        </div>
                    </form>
                    <p id="user-alert" class="tw-text-red-600 tw-font-semibold tw-m-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" id="userForm-submit"><?= $lang['save'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset password modal -->
    <div class="modal fade ums-modal" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel"><?= $lang['resetpassword'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="resetPasswordForm">
                        <input type="hidden" id="resetUserId">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label"><?= $lang['newpassword'] ?></label>
                            <input type="password" class="form-control" id="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label"><?= $lang['confirmpassword'] ?></label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </form>
                    <p id="alert_box" class="tw-text-red-600 tw-font-semibold tw-m-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" id="resetPassword-submit"><?= $lang['save'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete confirm modal -->
    <div class="modal fade ums-modal" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><?= $lang['deleteusertitle'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="tw-m-0"><?= $lang['deleteusertext'] ?> <strong id="deleteUserName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import result modal -->
    <div class="modal fade ums-modal" id="importResultModal" tabindex="-1" aria-labelledby="importResultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importResultModalLabel"><?= $lang['import'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="importResultBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?= $lang['confirm'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-user-management.html"; ?>
</body>

</html>
