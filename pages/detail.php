<?php
include '../components/session.php';
$courseCode = $_GET['courseCode'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <br>

    <div class="main-inner bg-white">
        <div class="main-container" id="detail_div" name="detail_div"></div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>