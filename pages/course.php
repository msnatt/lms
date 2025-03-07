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
            <br>
            <br>
            <div class="d-flex justify-content-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                    </svg>
                </span>

                <h3>Course</h3>
            </div>
            <br>
            <br>
            <br>
            <br>
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