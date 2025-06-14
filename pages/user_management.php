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
    <title>UMS - E-learning</title>
</head>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4 text-center" style="max-width: 100%">UMS - <?= $lang['ums'] ?></h2>
                <div class="px-4 d-flex justify-content-start gap-2 mb-2">
                    <button class="btn btn-outline-secondary" style="width: 33%; max-width: 100px;" onclick="Import_csv()"><?= $lang['import'] ?></button>
                    <button class="btn btn-outline-secondary" style="width: 33%; max-width: 100px;" onclick="Export_csv()"><?= $lang['export'] ?></button>
                </div>
                <!-- ซ่อน input file -->
                <input type="file" id="csvInput" class="d-none" accept=".csv" onchange="handleFileUpload(event)">

                <div class="px-4" style="min-height: 60vh;">
                    <table id="table_user">
                        <thead>
                            <tr>
                                <th style="width: 20%;"><?= $lang['name'] ?> </th>
                                <th style="width: 10%;"><?= $lang['code'] ?> </th>
                                <th style="width: 10%;"><?= $lang['username'] ?> </th>
                                <th style="width: 10%;"><?= $lang['tel'] ?> </th>
                                <th style="width: 10%;"><?= $lang['roles'] ?> </th>
                                <th style="width: 20%;"><?= $lang['action'] ?> </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- reset password -->
    <!-- Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="resetPasswordForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </form>
                    <p id="alert_box"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitResetPassword()">Reset</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal ยืนยันการลบ -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirm user deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the user? <strong id="deleteUserName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- rename -->
    <!-- Modal -->
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameModalLabel"><?= $lang['newname'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="newname" class="form-label"><?= $lang['newname'] ?></label>
                        <input type="text" class="form-control" id="newname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" onclick="submitRename()"><?= $lang['update'] ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-user-management.html"; ?>
</body>

</html>