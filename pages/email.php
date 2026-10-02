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
    <title><?= $lang['emailmanagement'] ?> - E-learning</title>

    <!-- Tailwind (scoped to email.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        /* Page-scoped only — beat the global orange input:focus in include/style.html */
        .email-panel .form-control:focus,
        .email-panel .form-select:focus,
        .email-modal .form-control:focus,
        .email-modal .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }

        .recipient-scroll {
            max-height: 45vh;
            overflow-y: auto;
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
                        <i class="bi bi-envelope-fill tw-text-brand"></i><?= $lang['emailmanagement'] ?>
                    </h2>
                </div>

                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-6">

                    <!-- LEFT: compose -->
                    <div class="lg:tw-col-span-2 tw-bg-white tw-rounded-xl tw-shadow tw-p-4 email-panel">
                        <div class="mb-3">
                            <label for="compose-subject" class="form-label tw-text-sm tw-text-slate-600"><?= $lang['subject'] ?></label>
                            <input type="text" id="compose-subject" class="form-control" maxlength="200" required>
                        </div>
                        <div class="mb-2">
                            <label for="compose-body" class="form-label tw-text-sm tw-text-slate-600"><?= $lang['contenttext'] ?></label>
                            <textarea id="compose-body" class="form-control" rows="10" required></textarea>
                            <div class="tw-text-xs tw-text-slate-400 tw-mt-1"><i class="bi bi-info-circle tw-mr-1"></i><?= $lang['plaintextnote'] ?></div>
                        </div>

                        <!-- selected recipients -->
                        <div class="tw-mt-4 tw-border-t tw-border-solid tw-border-slate-100 tw-pt-3">
                            <div class="tw-flex tw-items-center tw-justify-between tw-mb-2">
                                <span class="tw-text-sm tw-font-semibold tw-text-slate-700">
                                    <?= $lang['selectedcount'] ?>: <span id="recipient-count">0</span>
                                </span>
                                <button type="button" id="clear-recipients"
                                    class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200">
                                    <?= $lang['clearselected'] ?>
                                </button>
                            </div>
                            <div id="recipient-chips" class="tw-flex tw-flex-wrap tw-gap-2 tw-min-h-[2rem]"></div>
                        </div>

                        <div class="tw-mt-4 tw-flex tw-items-center tw-gap-3">
                            <button type="button" id="btn-send"
                                class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-5 tw-py-2 tw-font-medium disabled:tw-bg-slate-200 disabled:tw-text-slate-400"
                                disabled>
                                <i class="bi bi-send tw-mr-1"></i><?= $lang['send'] ?> (<span id="send-count">0</span>)
                            </button>
                            <p id="send-alert" class="tw-text-red-600 tw-font-semibold tw-m-0"></p>
                        </div>
                    </div>

                    <!-- RIGHT: recipient picker -->
                    <div class="lg:tw-col-span-1">
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-4 email-panel lg:tw-sticky lg:tw-top-4">
                            <h4 class="tw-text-base tw-font-bold tw-text-slate-700 tw-mb-3"><?= $lang['selectrecipient'] ?></h4>

                            <div class="tw-relative tw-mb-3">
                                <i class="bi bi-search tw-absolute tw-left-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-slate-400"></i>
                                <input id="search-recipient" type="text" class="form-control tw-pl-9"
                                    placeholder="<?= $lang['searchrecipient'] ?>">
                            </div>

                            <div id="picker-wrap">
                                <label class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-slate-600 tw-mb-2 tw-pb-2 tw-border-b tw-border-solid tw-border-slate-100">
                                    <input type="checkbox" id="check-all-recipient" class="form-check-input tw-m-0">
                                    <?= $lang['selectall'] ?>
                                </label>
                                <div id="recipient-list" class="recipient-scroll"></div>
                            </div>

                            <div id="empty-state"
                                class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-10 tw-text-slate-400">
                                <i class="bi bi-person-x tw-text-3xl tw-mb-2"></i>
                                <p class="tw-m-0 tw-text-sm"><?= $lang['nouserwithemail'] ?></p>
                            </div>
                            <div id="error-state"
                                class="tw-hidden tw-flex-col tw-items-center tw-justify-center tw-py-10 tw-text-slate-500">
                                <i class="bi bi-exclamation-triangle tw-text-3xl tw-mb-2"></i>
                                <p class="tw-m-0 tw-mb-3 tw-text-sm"><?= $lang['loadfailed'] ?></p>
                                <button type="button" id="retry-btn"
                                    class="tw-bg-brand tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm"><?= $lang['tryagain'] ?></button>
                            </div>

                            <div class="tw-mt-4 tw-border-t tw-border-solid tw-border-slate-100 tw-pt-3">
                                <label for="manual-email" class="form-label tw-text-sm tw-text-slate-600"><?= $lang['manualemail'] ?></label>
                                <div class="tw-flex tw-gap-2">
                                    <input type="email" id="manual-email" class="form-control" placeholder="name@example.com">
                                    <button type="button" id="btn-add-manual"
                                        class="tw-bg-slate-100 tw-text-slate-600 tw-rounded-lg tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-border-0 hover:tw-bg-slate-200 tw-shrink-0">
                                        <?= $lang['addemail'] ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Send result modal -->
    <div class="modal fade email-modal" id="sendResultModal" tabindex="-1" aria-labelledby="sendResultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendResultModalLabel"><?= $lang['sendresult'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="sendResultBody"></div>
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
    <?php include "../include/scriptjs-email.html"; ?>
</body>

</html>
