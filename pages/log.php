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
    <title><?= $lang['logs'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-clock-history"></i></span>
                    <h2><?= $lang['logs'] ?></h2>
                </div>

                <div class="result-stats" id="log-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-list-ul"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totallog'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-calendar-day"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-today">0</div>
                            <div class="result-stat-label"><?= $lang['logtoday'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-latest">-</div>
                            <div class="result-stat-label"><?= $lang['latestlog'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <div class="btn-c" id="action_btn" onclick="switchTab('login')"><?= $lang['logins'] ?></div>
                        <div class="btn-c" id="error_btn" onclick="switchTab('error')"><?= $lang['error'] ?></div>
                        <div class="btn-c" id="log_action_btn" onclick="switchTab('action')"><?= $lang['useraction'] ?></div>
                    </div>

                    <div class="toolbar">
                        <input type="text" id="log-search" class="form-control" style="max-width: 320px;" placeholder="<?= $lang['searchlog'] ?>" oninput="filterLogs()">
                        <button class="btn btn-outline-secondary" onclick="loadLogs()"><i class="bi bi-arrow-clockwise me-1"></i><?= $lang['refresh'] ?></button>
                    </div>

                    <div class="cert-table-wrap">
                        <table id="table_log">
                            <thead>
                                <tr id="log-thead-row"></tr>
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

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-logs.html"; ?>
</body>

</html>
