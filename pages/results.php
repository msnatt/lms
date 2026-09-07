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
    <title><?= $lang['result'] ?> - E-learning</title>
    <style>
        .result-wrap {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-card {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fff;
            padding: 1rem;
            height: 100%;
        }

        .stat-card .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: .85rem;
            color: #6c757d;
        }

        .result-progress {
            height: 10px;
            border-radius: 6px;
            background: #e9ecef;
            overflow: hidden;
        }

        .result-progress > span {
            display: block;
            height: 100%;
            background: #F28222;
            border-radius: 6px;
            transition: width .4s ease;
        }

        .course-result-card {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
        }

        .course-result-card .crc-head {
            padding: .9rem 1rem;
            border-bottom: 1px solid #eee;
            background: #fafafa;
        }

        .course-result-card table {
            margin: 0;
        }

        .score-badge {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        #score-chart-box {
            position: relative;
            height: 260px;
        }

        @media print {

            header,
            footer,
            .sidebar,
            #sidebar_btn,
            #result-toolbar,
            #result-actions,
            .btn-back-result {
                display: none !important;
            }

            .main-inner,
            .bg-light,
            body {
                background: #fff !important;
            }

            .course-result-card,
            .stat-card {
                break-inside: avoid;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>

            <div class="container-fluid bg-light py-3">
                <div class="result-wrap d-flex flex-column gap-3">

                    <!-- header row -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <button onclick="window.history.back();" class="btn btn-back-result">
                            <i class="bi bi-arrow-left fs-4"></i>
                        </button>
                        <h4 class="m-0 text-center flex-grow-1">
                            <?= $lang['result'] ?> <?= $lang['all'] ?>
                        </h4>
                        <div id="result-actions" class="d-flex gap-2">
                            <button id="btn-print" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-printer"></i> <?= $lang['print'] ?>
                            </button>
                            <button id="btn-pdf" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> <?= $lang['downloadpdf'] ?>
                            </button>
                        </div>
                    </div>

                    <!-- student info -->
                    <div class="stat-card">
                        <div class="fw-bold">
                            <?= htmlspecialchars($user['code'] ?? '') ?> - <?= htmlspecialchars($user['name'] ?? '') ?>
                        </div>
                        <div class="text-muted small"><?= htmlspecialchars($user['rank'] ?? '') ?></div>
                    </div>

                    <!-- summary stat cards -->
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div id="stat-overall" class="stat-value">-</div>
                                <div class="stat-label"><?= $lang['overallscore'] ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div id="stat-avg" class="stat-value">-</div>
                                <div class="stat-label"><?= $lang['avgscore'] ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div id="stat-courses" class="stat-value">-</div>
                                <div class="stat-label"><?= $lang['coursestaken'] ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card text-center">
                                <div id="stat-exams" class="stat-value">-</div>
                                <div class="stat-label"><?= $lang['examstaken'] ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- chart -->
                    <div id="chart-card" class="stat-card">
                        <div class="fw-bold mb-2"><?= $lang['scorebycourse'] ?></div>
                        <div id="score-chart-box">
                            <canvas id="score-chart"></canvas>
                        </div>
                    </div>

                    <!-- toolbar -->
                    <div id="result-toolbar" class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <input type="text" id="search-input" class="form-control"
                                placeholder="<?= $lang['searchresult'] ?>">
                        </div>
                        <div class="col-6 col-lg-3">
                            <select id="filter-course" class="form-select">
                                <option value=""><?= $lang['allcourses'] ?></option>
                            </select>
                        </div>
                        <div class="col-6 col-lg-3">
                            <select id="sort-select" class="form-select">
                                <option value="newest"><?= $lang['sortby'] ?>: <?= $lang['newest'] ?></option>
                                <option value="high"><?= $lang['sortby'] ?>: <?= $lang['highscore'] ?></option>
                                <option value="low"><?= $lang['sortby'] ?>: <?= $lang['lowscore'] ?></option>
                                <option value="name"><?= $lang['sortby'] ?>: <?= $lang['bycoursename'] ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- results list -->
                    <div id="results-list" class="d-flex flex-column gap-3" style="min-height: 30vh;"></div>

                    <div id="empty-state" class="text-center text-muted py-5" hidden>
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <?= $lang['noresult'] ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <?php include "../include/scriptjs-results.html"; ?>
</body>

</html>
