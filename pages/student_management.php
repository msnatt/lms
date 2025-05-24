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
    <meta charset="UTF-8">
    <title>SMS - E-learning</title>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4 text-center" style="max-width: 100%">SMS - <?=$lang['sms']?>.</h2>
                <div class="px-4 d-flex flex-wrap justify-content-center  gap-3 ">
                    <select id="select-course" class="w-75 form-select" required>
                        <option value="">=== <?=$lang['select']?> <?=$lang['course']?> ===</option>
                    </select>
                    <button class="btn btn-primary col-12 col-lg-2" style="max-width: 150px;" onclick="registerall()"><?=$lang['registerc']?><?=$lang['all']?></button>
                </div>
                <div class="px-4 d-flex justify-content-center">
                    <div id="select-list" class="d-flex flex-wrap m-4 gap-2" style="width: 600px; min-height: 30px;"></div>
                </div>
                <div id="student_list" class="mt-3 d-flex flex-column align-items-center" style="min-height: 60vh;">
                    <table id="table_list_student" style="max-width: 800px;">
                        <thead>
                            <tr>
                                <th style="width: 40px !important;"></th>
                                <th><?=$lang['code']?></th>
                                <th><?=$lang['name']?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-student-management.html"; ?>
</body>

</html>