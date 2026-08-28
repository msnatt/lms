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

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-people"></i></span>
                    <h2><?= $lang['ums'] ?></h2>
                </div>

                <div class="result-stats" id="user-stats">
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-total">0</div>
                            <div class="result-stat-label"><?= $lang['totaluser'] ?></div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-person-badge"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-admin">0</div>
                            <div class="result-stat-label">Admin</div>
                        </div>
                    </div>
                    <div class="result-stat">
                        <div class="result-stat-icon"><i class="bi bi-mortarboard"></i></div>
                        <div>
                            <div class="result-stat-value" id="stat-student">0</div>
                            <div class="result-stat-label">Student</div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="toolbar">
                        <input type="text" id="user-search" class="form-control" style="max-width: 320px;" placeholder="<?= $lang['searchuser'] ?>" oninput="filterUsers()">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary" onclick="Import_csv()"><i class="bi bi-upload me-1"></i><?= $lang['import'] ?></button>
                            <button class="btn btn-outline-secondary" onclick="Export_csv()"><i class="bi bi-download me-1"></i><?= $lang['export'] ?></button>
                        </div>
                    </div>
                    <!-- ซ่อน input file -->
                    <input type="file" id="csvInput" class="d-none" accept=".csv" onchange="handleFileUpload(event)">

                    <div class="cert-table-wrap">
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

                    <div class="pagination-bar">
                        <button class="page-link" id="prev-page" disabled><i class="bi bi-chevron-left"></i></button>
                        <span><span class="fw-semibold" id="current-page">1</span> / <span id="total-pages">1</span></span>
                        <button class="page-link" id="next-page"><i class="bi bi-chevron-right"></i></button>
                    </div>
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
                    <h5 class="modal-title" id="resetPasswordModalLabel"><?= $lang['resetpassword'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="resetPasswordForm">
                        <input type="hidden" id="resetUserId">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label"><?= $lang['newpassword'] ?></label>
                            <input type="password" class="form-control" id="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label"><?= $lang['confirmpassword'] ?></label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </form>
                    <p id="alert_box"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" onclick="submitResetPassword()"><?= $lang['confirm'] ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal ยืนยันการลบ -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><?= $lang['confirmdelete'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= $lang['confirmdeleteuser'] ?> <strong id="deleteUserName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit user -->
    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel"><?= $lang['edituser'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label"><?= $lang['name'] ?></label>
                        <input type="text" class="form-control" id="edit-name" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-username" class="form-label"><?= $lang['username'] ?></label>
                        <input type="text" class="form-control" id="edit-username" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telephone" class="form-label"><?= $lang['tel'] ?></label>
                        <input type="text" class="form-control" id="edit-telephone" maxlength="10">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-primary" onclick="submitEditUser()"><?= $lang['update'] ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-user-management.html"; ?>
</body>

</html>
