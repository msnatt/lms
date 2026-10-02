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
    <title><?= $lang['quizmanagement'] ?> - E-learning</title>

    <!-- Tailwind (scoped to quiz_management.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        .qms-table {
            border-collapse: collapse;
            width: 100%;
            font-family: inherit;
        }

        .qms-table th {
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

        .qms-table td {
            border: 0;
            border-top: 1px solid #f1f5f9;
            padding: .55rem .75rem;
            color: #334155;
            vertical-align: middle;
        }

        .qms-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .qms-table tbody tr:hover {
            background: #f0f9ff;
        }

        .qms-panel .form-control:focus,
        .qms-panel .form-select:focus,
        .qms-modal .form-control:focus,
        .qms-modal .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }

        .qms-modal .q-block {
            border: 1px solid #e2e8f0;
            border-radius: .75rem;
            padding: .85rem;
            margin-bottom: .75rem;
            background: #f8fafc;
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
                        <i class="bi bi-pen-fill tw-text-brand"></i><?= $lang['ems'] ?>
                    </h2>
                    <span id="exam-total"
                        class="tw-text-sm tw-bg-sky-50 tw-text-brand tw-rounded-full tw-px-3 tw-py-0.5 tw-font-medium">0</span>
                </div>

                <!-- Toolbar -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 tw-mb-4 qms-panel">
                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-3">
                        <div class="lg:tw-col-span-2">
                            <div class="tw-relative">
                                <i class="bi bi-search tw-absolute tw-left-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-slate-400"></i>
                                <input id="search-exam" type="text" class="form-control tw-pl-9"
                                    placeholder="<?= $lang['searchexam'] ?>">
                            </div>
                        </div>
                        <div>
                            <select id="filter-type" class="form-select">
                                <option value=""><?= $lang['alltype'] ?></option>
                                <option value="pre-test"><?= $lang['pretest'] ?></option>
                                <option value="post-test"><?= $lang['posttest'] ?></option>
                                <option value="quiz"><?= $lang['quizlabel'] ?></option>
                            </select>
                        </div>
                        <div>
                            <select id="sort-by" class="form-select">
                                <option value="newest"><?= $lang['sortnewest'] ?></option>
                                <option value="oldest"><?= $lang['sortoldest'] ?></option>
                                <option value="title"><?= $lang['sorttitle'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="tw-mt-3">
                        <button type="button" id="btn-create"
                            class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-font-medium">
                            <i class="bi bi-plus-lg tw-mr-1"></i><?= $lang['createexam'] ?>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden">
                    <div id="table-wrap" class="tw-max-h-[60vh] tw-overflow-y-auto tw-overflow-x-auto">
                        <table id="table_exam" class="qms-table">
                            <thead>
                                <tr>
                                    <th><?= $lang['title-ems'] ?></th>
                                    <th><?= $lang['type-ems'] ?></th>
                                    <th><?= $lang['start-ems'] ?></th>
                                    <th><?= $lang['period-ems'] ?> (<?= $lang['minute'] ?>)</th>
                                    <th><?= $lang['questioncount'] ?></th>
                                    <th><?= $lang['createdate'] ?></th>
                                    <th class="tw-text-right"><?= $lang['action'] ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="empty-state"
                        class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-12 tw-text-slate-400">
                        <i class="bi bi-clipboard-x tw-text-4xl tw-mb-2"></i>
                        <p class="tw-m-0"><?= $lang['noexam'] ?></p>
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

    <!-- Create exam modal -->
    <div class="modal fade qms-modal" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel"><?= $lang['createexam'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="row g-2">
                            <div class="col-12 col-lg-6">
                                <label for="f-title" class="form-label"><?= $lang['title-ems'] ?></label>
                                <input type="text" class="form-control" id="f-title" maxlength="255" required>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="f-start" class="form-label"><?= $lang['start-ems'] ?></label>
                                <input type="datetime-local" class="form-control" id="f-start" required>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="f-period" class="form-label"><?= $lang['period-ems'] ?> (<?= $lang['minute'] ?>)</label>
                                <input type="number" class="form-control" id="f-period" min="1" max="1440" required>
                            </div>
                            <div class="col-12">
                                <label for="f-desc" class="form-label"><?= $lang['description'] ?></label>
                                <textarea class="form-control" id="f-desc" rows="2" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?= $lang['type-ems'] ?></label>
                                <div class="tw-flex tw-flex-wrap tw-gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="f-type" id="f-type-pre" value="pre-test" required>
                                        <label class="form-check-label" for="f-type-pre"><?= $lang['pretest'] ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="f-type" id="f-type-post" value="post-test">
                                        <label class="form-check-label" for="f-type-post"><?= $lang['posttest'] ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="f-type" id="f-type-quiz" value="quiz">
                                        <label class="form-check-label" for="f-type-quiz"><?= $lang['quizlabel'] ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="tw-flex tw-items-center tw-justify-between tw-mb-2">
                            <span class="tw-font-semibold tw-text-slate-700"><?= $lang['question'] ?></span>
                            <button type="button" id="btn-add-question"
                                class="tw-bg-slate-100 tw-text-slate-600 tw-border-0 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium hover:tw-bg-slate-200">
                                <i class="bi bi-plus-lg tw-mr-1"></i><?= $lang['addquestionbtn'] ?>
                            </button>
                        </div>
                        <div id="question-list"></div>
                    </form>
                    <p id="create-alert" class="tw-text-red-600 tw-font-semibold tw-m-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" id="create-submit"><?= $lang['create'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam detail modal -->
    <div class="modal fade qms-modal" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"><?= $lang['examdetail'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="detail-title" class="tw-text-lg tw-font-bold tw-text-brandink tw-mb-1"></h4>
                    <p id="detail-meta" class="tw-text-sm tw-text-slate-500 tw-mb-4"></p>
                    <div id="detail-questions"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['close'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete confirm modal -->
    <div class="modal fade qms-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><?= $lang['deleteexamtitle'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="tw-m-0"><?= $lang['deleteexamtext'] ?> <strong id="delete-exam-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script id="lang-data" type="application/json"><?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?></script>
    <?php include "../include/scriptjs-quiz-management.html"; ?>
</body>

</html>
