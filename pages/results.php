<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<head>
    <meta charset="UTF-8">
    <title>Result - E-learning</title>
</head>

<body class="fw-medium">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <!-- <div class="main-container">
            <h3 class="p-4">FT - LMS</h3>
        </div> -->
        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>

            <div class="container d-flex bg-light mt-2">
                <div id="table-container" class="d-flex align-items-center flex-column w-100">
                    <div class="w-100 d-flex">
                        <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                        <div class="fs-4 py-4 col-10 text-center"><?php echo $user['code'];
                                                echo (" - ");
                                                echo $user['name']; ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-results.html"; ?>
</body>

</html>