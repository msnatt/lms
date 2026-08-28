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
    <title><?= $lang['catalogue'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-journals"></i></span>
                    <h2><?= $lang['catalogue'] ?></h2>
                </div>

                <div class="result-stats" id="catalogue-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-building"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-faculty">0</div>
                            <div class="result-stat-label"><?= $lang['faculty'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-diagram-3"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-department">0</div>
                            <div class="result-stat-label"><?= $lang['department'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-journal-text"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-course">0</div>
                            <div class="result-stat-label"><?= $lang['allcourse'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="toolbar">
                        <input type="text" id="catalogue-search" class="form-control" style="max-width: 320px;" placeholder="<?= $lang['searchcourse'] ?>" oninput="filterCatalogue()">
                        <button type="button" class="btn btn-outline-secondary" id="toggle-all-btn" onclick="toggleAll()"><i class="bi bi-arrows-expand me-1"></i><?= $lang['expandall'] ?></button>
                    </div>

                    <div id="catalogue_div" class="degree-course"></div>
                </div>

            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <script id="user-data" type="application/json">
        <?= json_encode(['is_admin' => !empty($user['is_admin'])], JSON_UNESCAPED_UNICODE) ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course_catalogue.html"; ?>
</body>

</html>
