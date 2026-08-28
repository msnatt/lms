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
    <title><?= $lang['certificate'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-patch-check"></i></span>
                    <h2><?= $lang['certificatemanagement'] ?></h2>
                </div>

                <div class="result-stats" id="cert-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totalstudent'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-check2-square"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-selected">0</div>
                            <div class="result-stat-label"><?= $lang['selectedstudent'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-file-earmark-image"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-templates">0</div>
                            <div class="result-stat-label"><?= $lang['template'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-7">

                        <div class="panel mb-3">
                            <h3><span class="step-badge">1</span><?= $lang['steptemplate'] ?></h3>
                            <select id="select-template" class="form-select" required>
                                <option value="">=== <?= $lang['templateblank'] ?> ===</option>
                            </select>
                        </div>

                        <div class="panel mb-3">
                            <h3><span class="step-badge">2</span><?= $lang['stepstudent'] ?></h3>

                            <input type="text" id="student-search" class="form-control" placeholder="<?= $lang['searchstudent'] ?>" oninput="filterStudents()">
                            <div class="text-muted small mt-2" id="student-count"></div>

                            <div id="select-list" class="cert-chips">
                                <div class="cert-chips-empty"><?= $lang['nostudentselected'] ?></div>
                            </div>

                            <div id="student_list" class="cert-table-wrap">
                                <table id="table_list_student">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px !important;"></th>
                                            <th><?= $lang['code'] ?></th>
                                            <th><?= $lang['name'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel-soft">
                            <h3><span class="step-badge">3</span><?= $lang['stepexport'] ?></h3>
                            <button class="btn btn-primary w-100" onclick="Export()">
                                <i class="bi bi-download me-1"></i><?= $lang['export'] ?>
                            </button>
                        </div>

                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="panel cert-preview">
                            <h3><i class="bi bi-eye"></i><?= $lang['pretemplate'] ?></h3>
                            <div class="cert-preview-frame">
                                <img id="image-Show" src="../assets/images/default-template.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-certificate.html"; ?>
</body>

</html>
