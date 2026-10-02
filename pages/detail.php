<?php
include '../components/session.php';
checkLogin();

$courseid = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? (int) $_GET['courseid'] : 0;
$user = is_array($_SESSION['user'] ?? null) ? $_SESSION['user'] : [];
$course = is_array($_SESSION['course'] ?? null) ? $_SESSION['course'] : [];
$owner = is_array($_SESSION['owner'] ?? null) ? $_SESSION['owner'] : [];

$courseTitle = $course['name'] ?? '';
$isAdmin = ($user['is_admin'] ?? '0') == "1";
$canEdit = $isAdmin && ($course['create_by'] ?? null) == ($user['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title><?= htmlspecialchars($courseTitle !== '' ? $courseTitle : 'Course') ?> - E-learning</title>

    <!-- Tailwind (scoped to detail.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        /* input:focus ของ style.html ยังเป็นขอบส้มเดิม (ใช้ร่วมทั้งระบบ) ทับด้วยสีฟ้าของแบรนด์ใหม่เฉพาะหน้านี้ */
        #member-modal .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }

        #hero-image {
            object-position: center;
        }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">

            <!-- HERO (เติมโดย scriptjs-detail.html) -->
            <div id="hero" class="tw-relative tw-h-[38vh] md:tw-h-[45vh] tw-bg-slate-200 tw-overflow-hidden">
                <img id="hero-image" class="tw-w-full tw-h-full tw-object-cover" alt="">
                <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-black/75 tw-via-black/40 tw-to-black/10"></div>
                <div class="tw-absolute tw-inset-0 tw-flex tw-flex-col tw-justify-end">
                    <div class="tw-max-w-6xl tw-w-full tw-mx-auto tw-px-4 tw-pb-5 tw-text-white">
                        <button type="button" onclick="window.history.back();" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-white/15 hover:tw-bg-white/25 tw-border-0 tw-text-white tw-rounded-full tw-px-3 tw-py-1 tw-mb-3 tw-text-sm">
                            <i class="bi bi-arrow-left"></i> <?= $lang['back'] ?>
                        </button>
                        <h1 id="hero-title" class="tw-text-xl md:tw-text-3xl tw-font-bold tw-mb-1"></h1>
                        <p id="hero-desc" class="tw-text-sm md:tw-text-base tw-opacity-90 tw-mb-3" style="max-width: 60ch;"></p>
                        <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3">
                            <div id="hero-meta" class="tw-flex tw-flex-wrap tw-gap-x-4 tw-gap-y-1 tw-text-sm tw-opacity-90"></div>
                            <div id="hero-cta"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB BAR -->
            <div id="tab-bar-wrapper" class="tw-sticky tw-top-0 tw-z-20 tw-bg-white tw-border-b tw-border-slate-200 tw-shadow-sm">
                <div class="tw-max-w-6xl tw-mx-auto tw-px-2 tw-flex tw-gap-1 tw-overflow-x-auto" id="tab-bar" role="tablist">
                    <button type="button" class="detail-tab-btn tw-inline-flex tw-items-center tw-gap-2 tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-border-0 tw-border-b-2 tw-border-transparent tw-text-slate-500 tw-bg-transparent hover:tw-text-brand" data-tab="content" role="tab"><i class="bi bi-journal-text"></i> <?= $lang['course'] ?></button>
                    <button type="button" class="detail-tab-btn tw-inline-flex tw-items-center tw-gap-2 tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-border-0 tw-border-b-2 tw-border-transparent tw-text-slate-500 tw-bg-transparent hover:tw-text-brand" data-tab="info" role="tab"><i class="bi bi-info-circle"></i> <?= $lang['information'] ?></button>
                    <button type="button" class="detail-tab-btn tw-inline-flex tw-items-center tw-gap-2 tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-border-0 tw-border-b-2 tw-border-transparent tw-text-slate-500 tw-bg-transparent hover:tw-text-brand" data-tab="schedule" role="tab"><i class="bi bi-calendar-week"></i> <?= $lang['timetable'] ?></button>
                    <button type="button" class="detail-tab-btn tw-inline-flex tw-items-center tw-gap-2 tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-border-0 tw-border-b-2 tw-border-transparent tw-text-slate-500 tw-bg-transparent hover:tw-text-brand" data-tab="members" role="tab"><i class="bi bi-people"></i> <?= $lang['memberc'] ?></button>
                </div>
            </div>

            <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-py-6">
                <div id="panel-content" data-panel="content"></div>
                <div id="panel-info" data-panel="info" hidden></div>
                <div id="panel-schedule" data-panel="schedule" hidden></div>
                <div id="panel-members" data-panel="members" hidden></div>
            </div>
        </div>

        <?php if ($canEdit): ?>
            <div style="position: fixed; bottom: 5%; right: 3%;">
                <button class="tw-w-14 tw-h-14 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 tw-shadow-lg tw-text-2xl hover:tw-opacity-90" onclick="window.location.href = '../pages/course_edit.php?courseid=<?php echo $courseid; ?>'">
                    <i class="bi bi-pencil"></i>
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal: จัดการสมาชิก -->
    <div class="modal fade" id="member-modal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel"><?= $lang['managemember'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="member-search" class="form-control mb-3" placeholder="<?= $lang['searchmember'] ?>">
                    <div class="table-responsive">
                        <table class="table" id="member-table">
                            <thead>
                                <tr>
                                    <th><?= $lang['name'] ?></th>
                                    <th><?= $lang['code'] ?></th>
                                    <th><?= $lang['roles'] ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="member-table-body"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: ยืนยันถอนสมาชิก -->
    <div class="modal fade" id="confirm-remove-modal" tabindex="-1" aria-labelledby="confirmRemoveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmRemoveModalLabel"><?= $lang['confirm'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= $lang['confirmremovemember'] ?> <strong id="remove-member-name"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirm-remove-btn"><?= $lang['removemember'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <script>
        window.COURSE_ID = <?= json_encode($courseid) ?>;
        window.CURRENT_USER_ID = <?= json_encode($user['id'] ?? null) ?>;
        window.IS_ADMIN = <?= json_encode($isAdmin) ?>;
        window.OWNER_NAME = <?= json_encode($owner['name'] ?? '', JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>
