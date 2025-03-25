<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <div class="main-container">
            <h3 class="p-4">Ft - LMS</h3>
        </div>

        <div class="bg-light main-container">
            <div class="d-flex justify-content-center mt-4">
                <i class="bi bi-gear-fill fs-2"></i>
                <h3>&nbsp;&nbsp;Course</h3>
            </div>
            <hr>
            <div id="course_div" name="course_div" class="row justify-content-center g-6"></div>

            <br>
            <br>
            <!-- Pagination -->
            <div class="pagination mt-4">
                <div class="row">
                    <div class="col-4 d-flex justify-content-center">
                        <button class="page-link" id="prev-page" disabled>&lt;</button>
                    </div>
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <span class="page-link" id="current-page">1</span> / <span id="total-pages">1</span>
                    </div>
                    <div class="col-4 d-flex justify-content-center">
                        <button class="page-link" id="next-page">&gt;</button>
                    </div>
                </div>
            </div>
            <br>
            <?php if ($user['is_admin'] == "1"): ?>
                <div style="position: fixed; bottom: 10%; right: 3%;">
                    <button class="menuquickly" onclick="window.location.href = '../pages/course_create.php'">
                        <img src="../assets/images/add.png" width="25px" height="25px" />
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course.html"; ?>
</body>

</html>