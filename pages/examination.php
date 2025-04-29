<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body>
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <!-- <div class="main-container">
            <h3 class="p-4">FT - LMS</h3>
        </div> -->
        <div class="" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>

            <div id="exam-container" class="container p-4 justify-content-center">
                <h1 id="exam-title"></h1>
                <p id="exam-description" class="text-muted"></p>
                <button id="startExamBtn" class="btn btn-primary" onclick="startExam()">เริ่ม!</button>
            </div>
            <div id="toggle-form" class=" container d-none px-5">
                <form id="exam-form" class="w-100 d-flex flex-column">
                    <div id="questions-list"></div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3" style="width: 100%; max-width: 200px;">ส่งคำตอบ</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-examination.html"; ?>
</body>

</html>