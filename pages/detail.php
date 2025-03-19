<?php
include '../components/session.php';
$courseid = $_GET['courseid'] ?? 'N/A';
$user = $_SESSION['user'] ?? 'N/A';
$course = $_SESSION['course'] ?? 'N/A';

?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <br>
    <div class="main-inner">
        <div class="main-container bg-white bg-shadow" style="min-height: 70vh;" id="detail_div" name="detail_div"></div>

        <?php if ($user['is_admin'] == "1" && $course['create_by'] == "1"): ?>
                <div style="position: fixed; bottom: 10%; right: 3%;">
                    <button class="menuquickly">
                        <img src="../assets/images/edit.png" width="25px" height="25px" />
                    </button>
                </div>
        <?php endif; ?>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>