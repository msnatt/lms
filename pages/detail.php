<?php
include '../components/session.php';
checkLogin();
$courseid = $_GET['courseid'] ?? 'N/A';
$user = $_SESSION['user'] ?? 'N/A';
$course = $_SESSION['course'] ?? 'N/A';
$owner = $_SESSION['owner'] ?? 'N/A';

?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<head>
    <title><?php echo $course['name'];?> - E-learning</title>
</head>

<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <br>
    <div class="d-flex" style="min-height: 70vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div class="main-container bg-white bg-shadow w-100" id="detail_div" name="detail_div"></div>

        <?php if ($user['is_admin'] == "1" && $course['create_by'] == $user['id']): ?>
            <div style="position: fixed; bottom: 10%; right: 3%;">
                <button class="menuquickly" onclick="window.location.href = '../pages/course_edit.php?courseid=<?php echo $courseid; ?>'">
                    <img src="../assets/images/edit.png" width="25px" height="25px" />
                </button>
            </div>
        <?php endif; ?>
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
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>