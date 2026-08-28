<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title>Result - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-clipboard-data"></i></span>
                    <div>
                        <h2><?= $lang['result'] ?><?= $lang['all'] ?></h2>
                        <div class="text-muted small"><?= htmlspecialchars($user['code'] ?? '') ?> &mdash; <?= htmlspecialchars($user['name'] ?? '') ?></div>
                    </div>
                </div>

                <div class="result-stats" id="result-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-journal-bookmark"></i></div>
                        <div>
                            <div class="dash-skeleton-line" style="width:36px;height:22px;"></div>
                            <div class="result-stat-label"><?= $lang['courses'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-pencil-square"></i></div>
                        <div>
                            <div class="dash-skeleton-line" style="width:36px;height:22px;"></div>
                            <div class="result-stat-label"><?= $lang['examstaken'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="dash-skeleton-line" style="width:36px;height:22px;"></div>
                            <div class="result-stat-label"><?= $lang['overallscore'] ?></div>
                        </div>
                    </div>
                </div>

                <div id="table-container" class="result-grid">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <div class="result-card">
                            <div class="result-card-head">
                                <div class="dash-skeleton-line" style="width:60%;height:16px;"></div>
                            </div>
                            <div class="result-card-body">
                                <div class="dash-skeleton-line" style="width:100%;"></div>
                                <div class="dash-skeleton-line" style="width:80%;"></div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-results.html"; ?>
</body>

</html>
