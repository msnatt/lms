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
    <title>SMS - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-book-half"></i></span>
                    <h2><?= $lang['sms'] ?></h2>
                </div>

                <div class="panel mb-3">
                    <h3><span class="step-badge">1</span><?= $lang['stepselectcourse'] ?></h3>
                    <select id="select-course" class="form-select" required>
                        <option value="">=== <?= $lang['select'] ?> <?= $lang['course'] ?> ===</option>
                    </select>
                </div>

                <div class="panel mb-3">
                    <h3><span class="step-badge">2</span><?= $lang['stepselectstudent'] ?></h3>

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
                    <h3><span class="step-badge">3</span><?= $lang['stepsave'] ?></h3>
                    <button class="btn btn-primary w-100" id="btn-save" onclick="registerall()">
                        <i class="bi bi-check2-circle me-1"></i><?= $lang['save'] ?>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-student-management.html"; ?>
</body>

</html>
