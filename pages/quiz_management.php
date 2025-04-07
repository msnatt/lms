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

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4" style="max-width: 100%">All Examination.</h2>
                <div class="px-4 d-flex justify-content-end gap-2">
                    <button class="btn btn-outline-secondary" style="width: 33%; max-width: 100px;" onclick="openExamCreate()">Create</button>
                </div>

                <div class="modal-dialog" style="width:100vw; max-Width:960px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="examCreateTitle">Create Examination.</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="examCreateForm">
                                <div class="d-flex w-100 justify-content-between px-2 my-2 flex-wrap">
                                    <div class="col-12 col-lg-3">
                                        <label for="Title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="Start-time" class="form-label">Start Time</label>
                                        <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="examination-period" class="form-label">Examination Period</label>
                                        <input type="time" class="form-control" id="exam-period" name="exam-period" required>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-1 my-3" style="min-height: 40vh;">
                                    <div class="rounded border p-2" style="width: 100%; max-width: 350px;">
                                        <label for="Title" class="form-label">Description.</label>
                                        <textarea class="form-control" style="min-height:150px;"  id="description" name="description" required></textarea>
                                    </div>
                                    <div class="rounded border p-2"  style="width: 100%; max-width: 600px;">
                                        <div class="w-100">
                                            <div></div>
                                        </div>
                                        <div id="question" class="w-100">


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="submitResetPassword()">Reset</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="px-4" style="min-height: 60vh;">
                    <table id="table_exam">
                        <thead>
                            <tr>
                                <th> Title </th>
                                <th> Type </th>
                                <th> start time </th>
                                <th> Exam period </th>
                                <th> Create at </th>
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
    <?php include "../include/scriptjs-quiz-management.html"; ?>
</body>

</html>