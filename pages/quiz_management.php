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
    <title>EMS - E-learning</title>
</head>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4 text-center" style="max-width: 100%">EMS - <?= $lang['ems'] ?>.</h2>
                <div class="px-4 d-flex justify-content-end gap-2 container">
                    <button class="btn btn-outline-secondary" style="width: 33%; max-width: 100px;" onclick="openExamCreate()"> <?= $lang['create'] ?></button>
                </div>
                <div class="mt-3" style="min-height: 60vh;">
                    <table class="container border rounded bg-secondary bg-opacity-10" id="table_exam">
                        <thead>
                            <tr>
                                <th> <?= $lang['title-ems'] ?> </th>
                                <th> <?= $lang['type-ems'] ?> </th>
                                <th> <?= $lang['start-ems'] ?> </th>
                                <th> <?= $lang['period-ems'] ?> (<?= $lang['minute'] ?>) </th>
                                <th> <?= $lang['createdate'] ?> </th>
                                <th> <?= $lang['action'] ?> </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal ยืนยันการลบ -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><?=$lang['confirmdelete']?><?=$lang['quiz']?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?=$lang['textconfirmdelete']?><?=$lang['quiz']?><strong id="deleteUserName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['cancel']?></button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?=$lang['delete']?></button>
                </div>
            </div>
        </div>
    </div>
    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-quiz-management.html"; ?>
</body>

</html>