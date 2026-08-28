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
    <title><?= $lang['notifies'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-send"></i></span>
                    <h2><?= $lang['emailmanagement'] ?></h2>
                </div>

                <div class="result-stats" id="email-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totaluser'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-check2-square"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-selected">0</div>
                            <div class="result-stat-label"><?= $lang['selectedstudent'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-7">

                        <div class="panel mb-3">
                            <h3><span class="step-badge">1</span><?= $lang['steprecipient'] ?></h3>

                            <input type="text" id="recipient-search" class="form-control" placeholder="<?= $lang['searchuser'] ?>" oninput="filterRecipients()">
                            <div class="text-muted small mt-2" id="recipient-count"></div>

                            <div id="select-list" class="cert-chips">
                                <div class="cert-chips-empty"><?= $lang['norecipientselected'] ?></div>
                            </div>

                            <div id="recipient_list" class="cert-table-wrap">
                                <table id="table_list_recipient">
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

                        <div class="panel mb-3">
                            <h3><span class="step-badge">2</span><?= $lang['stepotheremail'] ?></h3>
                            <input class="form-control" type="email" id="email_to" name="email_to" placeholder="example@email.com">
                        </div>

                        <div class="panel mb-3">
                            <h3><span class="step-badge">3</span><?= $lang['stepcontent'] ?></h3>
                            <textarea class="form-control" id="email_message" name="email_message" rows="5" required></textarea>
                        </div>

                        <div class="panel-soft">
                            <h3><span class="step-badge">4</span><?= $lang['stepsend'] ?></h3>
                            <button class="btn btn-primary w-100" id="btn-send" onclick="sendEmail()">
                                <i class="bi bi-send me-1"></i><?= $lang['send'] ?> Email
                            </button>
                        </div>

                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="panel cert-preview">
                            <h3><i class="bi bi-eye"></i><?= $lang['emailpreview'] ?></h3>
                            <div class="mb-2">
                                <div class="text-muted small"><?= $lang['recipients'] ?></div>
                                <div id="preview-recipients" class="fw-semibold"><?= $lang['norecipientselected'] ?></div>
                            </div>
                            <div>
                                <div class="text-muted small"><?= $lang['contenttext'] ?></div>
                                <div id="preview-message" class="fw-semibold" style="white-space: pre-wrap;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-email.html"; ?>
</body>

</html>
