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
    <title><?= $lang['mycourse'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-book-half"></i></span>
                    <h2><?= $lang['mycourse'] ?></h2>
                </div>

                <div id="course_div" name="course_div" class="d-flex flex-wrap justify-content-center" style="min-height: 40svh;">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center" style="padding:1.5rem 0rem;">
                            <div class="skeleton-card">
                                <div class="skeleton-img"></div>
                                <div class="dash-skeleton">
                                    <div class="dash-skeleton-line" style="width:70%; height:16px;"></div>
                                    <div class="dash-skeleton-line" style="width:90%;"></div>
                                    <div class="dash-skeleton-line" style="width:60%;"></div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="pagination-bar">
                    <button class="page-link" id="prev-page" disabled><i class="bi bi-chevron-left"></i></button>
                    <span><span class="fw-semibold" id="current-page">1</span> / <span id="total-pages">1</span></span>
                    <button class="page-link" id="next-page"><i class="bi bi-chevron-right"></i></button>
                </div>

                <?php if ($user['is_admin'] == "1"): ?>
                    <div style="position: fixed; bottom: 10%; right: 3%;">
                        <button class="menuquickly" onclick="window.location.href = '../pages/course_create.php'">
                            <img src="../assets/images/add.png" width="25px" height="25px" />
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-mycourse.html"; ?>
</body>

</html>
