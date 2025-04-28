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
        <!-- <div class="main-container">
            <h3 class="p-4">FT - LMS</h3>
        </div> -->
        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>

            <div id="table-container"></div>
        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-results.html"; ?>
</body>

</html>