<?php
include '../components/session.php';
checkLogin();
if (empty($_SESSION['user']['is_admin'])) {
    header("Location: ../pages/home.php");
    exit();
}
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['backup'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-database-fill-down"></i></span>
                    <h2><?= $lang['backup'] ?></h2>
                </div>

                <div class="result-stats" id="backup-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-file-earmark-zip"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totalbackup'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-hdd"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-size">0</div>
                            <div class="result-stat-label"><?= $lang['totalsize'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-latest">-</div>
                            <div class="result-stat-label"><?= $lang['latestbackup'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="toolbar">
                        <input type="text" id="backup-search" class="form-control" style="max-width: 320px;" placeholder="<?= $lang['searchbackup'] ?>" oninput="filterBackups()">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary" onclick="click_import()"><i class="bi bi-upload me-1"></i><?= $lang['import'] ?></button>
                            <button class="btn btn-primary" onclick="export_sql()"><i class="bi bi-download me-1"></i><?= $lang['export'] ?></button>
                        </div>
                    </div>
                    <!-- ซ่อน input file -->
                    <input type="file" id="sqlInput" class="d-none" accept=".sql" onchange="import_sql(event)">

                    <div class="cert-table-wrap">
                        <table id="table_backup">
                            <thead>
                                <tr>
                                    <th><?= $lang['time'] ?></th>
                                    <th><?= $lang['filename'] ?></th>
                                    <th><?= $lang['size'] ?></th>
                                    <th><?= $lang['action'] ?></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-bar">
                        <button class="page-link" id="prev-page" disabled><i class="bi bi-chevron-left"></i></button>
                        <span><span class="fw-semibold" id="current-page">1</span> / <span id="total-pages">1</span></span>
                        <button class="page-link" id="next-page"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal ยืนยันการนำเข้าข้อมูล -->
    <div class="modal fade" id="importConfirmModal" tabindex="-1" aria-labelledby="importConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importConfirmModalLabel"><?= $lang['confirmimport'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= $lang['textconfirmimport'] ?></p>
                    <p class="mb-0"><strong id="importFileName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmImportBtn" onclick="confirmImport()"><?= $lang['import'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-backup.html"; ?>
</body>

</html>
