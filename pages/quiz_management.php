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
    <title>EMS - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-journal-check"></i></span>
                    <h2><?= $lang['ems'] ?></h2>
                </div>

                <div class="result-stats" id="quiz-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-collection"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totalquiz'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-question-circle"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-questions">0</div>
                            <div class="result-stat-label"><?= $lang['totalquestion'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-upcoming">0</div>
                            <div class="result-stat-label"><?= $lang['upcomingquiz'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="toolbar">
                        <input type="text" id="quiz-search" class="form-control" style="max-width: 320px;" placeholder="<?= $lang['searchquiz'] ?>" oninput="filterQuizzes()">
                        <button class="btn btn-primary" onclick="openExamCreate()">
                            <i class="bi bi-plus-lg me-1"></i><?= $lang['create'] ?>
                        </button>
                    </div>

                    <div class="cert-table-wrap">
                        <table id="table_exam">
                            <thead>
                                <tr>
                                    <th><?= $lang['title-ems'] ?></th>
                                    <th><?= $lang['type-ems'] ?></th>
                                    <th><?= $lang['start-ems'] ?></th>
                                    <th><?= $lang['period-ems'] ?> (<?= $lang['minute'] ?>)</th>
                                    <th><?= $lang['questioncount'] ?></th>
                                    <th><?= $lang['createdate'] ?></th>
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

    <!-- Modal สร้างข้อสอบ -->
    <div class="modal fade" id="examCreateModal" tabindex="-1" aria-labelledby="examCreateTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="examCreateTitle"><?= $lang['create'] ?><?= $lang['exam'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="examCreateForm">
                        <div class="panel-soft mb-3">
                            <h3><span class="step-badge">1</span><?= $lang['stepexaminfo'] ?></h3>
                            <div class="row g-3">
                                <div class="col-12 col-lg-4">
                                    <label for="title" class="form-label"><?= $lang['title-ems'] ?></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="startTime" class="form-label"><?= $lang['start-ems'] ?></label>
                                    <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="exam-period" class="form-label"><?= $lang['period-ems'] ?> (<?= $lang['minute'] ?>)</label>
                                    <input type="number" class="form-control" id="exam-period" name="exam-period" required>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label"><?= $lang['description'] ?></label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><?= $lang['type-ems'] ?></label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="pre-test" name="examType" value="pre-test" required>
                                            <label class="form-check-label" for="pre-test">Pre-Test</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="post-test" name="examType" value="post-test">
                                            <label class="form-check-label" for="post-test">Post-Test</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="quiz" name="examType" value="quiz">
                                            <label class="form-check-label" for="quiz">Quiz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-soft">
                            <h3 class="d-flex justify-content-between align-items-center">
                                <span><span class="step-badge">2</span><?= $lang['stepquestion'] ?></span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addQuestion()">
                                    <i class="bi bi-plus-square me-1"></i><?= $lang['add'] ?><?= $lang['question'] ?>
                                </button>
                            </h3>
                            <div id="question" style="max-height: 420px; overflow-y: auto;"></div>
                            <div id="question-empty" class="cert-chips-empty"><?= $lang['noquestionyet'] ?></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" onclick="submitExamFormModal()"><?= $lang['create'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal รายละเอียดชุดข้อสอบ -->
    <div class="modal fade" id="quizDetailModal" tabindex="-1" aria-labelledby="quizDetailTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizDetailTitle"><?= $lang['quizdetail'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="quiz-detail-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['close'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ยืนยันการลบ -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><?= $lang['confirmdelete'] ?><?= $lang['quiz'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= $lang['textconfirmdelete'] ?><?= $lang['quiz'] ?> <strong id="deleteUserName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-quiz-management.html"; ?>
</body>

</html>
