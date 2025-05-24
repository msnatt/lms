<?php
include '../components/session.php';
checkLogin();
$courseid = $_GET['courseid'] ?? 'N/A';
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title><?=$lang['logs']?> - E-learning</title>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">

        <div class="d-flex" style="min-height: 60vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="bg-light  p-4 w-100" style="min-height: 60vh;">
                <div class="container w-100">
                    <div class="d-flex align-items-center">
                        <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                        <h3><?=$lang['logs']?></h3>
                    </div>
                    <div class="d-flex w-100 border rounded border-secondary-subtle" style="min-height: 60vh;">
                        <div id="log_list" class="w-75 border-end border-secondary-subtle">
                            <div class="p-2">
                                <table id="table_log">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;"><?= $lang['time'] ?></th>
                                            <th style="width: 20%;"><?= $lang['name'] ?></th>
                                            <th style="width: 20%;"><?= $lang['action'] ?></th>
                                            <th style="width: 40%;"><?= $lang['note'] ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="log_menu" class="w-25 d-flex justify-content-center">
                            <div class="w-100 px-4 d-flex flex-wrap gap-3 align-content-start justify-content-center">
                                <!-- <div class="w-100 px-4 "> -->
                                <h4 class="mt-3 d-flex justify-content-center"><?=$lang['typelogs']?></h4>
                                <hr>
                                <div class="btn-c w-100" id="action_btn" onclick=""><?=$lang['logins']?></div>
                                <div class="btn-c w-100" id="error_btn" onclick=""><?=$lang['error']?></div>
                                <!-- <div class="btn-c w-100" id="debug_btn" onclick="">Debug</div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-logs.html"; ?>
</body>

</html>