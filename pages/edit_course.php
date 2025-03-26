<?php
include '../components/session.php';
checkLogin();
$courseid = $_GET['courseid'] ?? 'N/A';
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">

        <div class="bg-light main-container p-4 mt-2" style="min-height: 60vh;">
            <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
            <span id="title_edit" style="font-size: 2rem; font-weight: 600;">Edit Course</span>
            <form id="form-course" class="d-flex flex-wrap">
                <input type="hidden" id="course_id" name="course_id" value="<?php echo $courseid; ?>">
                <input type="hidden" id="is_deleted" name="is_deleted" value="0">
                <div class="d-flex flex-column col-lg-3 col-12 rounded" style="padding: 0.5rem 0.25rem;">
                    <div class="bg-secondary p-4 rounded bg-opacity-10">
                        <div class="d-flex">
                            <div>
                                <label class="form-label">Name</label>
                                <input type="text" id="name_course" name="name_course" class="form-control">
                            </div>
                            <div>
                                <label class="form-label">Code</label>
                                <input type="text" id="code_course" name="code_course" class="form-control" oninput="validateNumberInput(event)">
                            </div>
                        </div>
                        <label class="form-label">Description</label>
                        <textarea id="textBoxDescription" name="textBoxDescription" rows="4" cols="50" class="form-control"></textarea>
                        <label class="form-label">Objective</label>
                        <textarea id="textBoxObjective" name="textBoxObjective" rows="4" cols="50" class="form-control"></textarea>
                        <div class="mt-5 d-flex g-5 justify-content-around">
                            <button type="button" class="btn btn-primary" onclick="update_course()" style="width: 40%;">
                                Update
                            </button>
                            <button type="button" class="btn btn-light" onclick="window.history.back();" style="width: 40%; border: 1px solid #ccc;">
                                Cancel
                            </button>
                        </div>
                        <div class="p-3">
                            <button type="button" class="btn btn-danger w-100" onclick="is_deleted_course()" style="width: 40%;">
                                <i class="bi bi-trash"></i>
                                Bin
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-7 col-12 rounded" style="padding: 0rem 0.25rem;">
                    <div class="bg-secondary p-2 rounded bg-opacity-10">
                        <div class="p-1 rounded d-flex">
                            <button type="button" class="btn btn-secondary col-6 col-lg-2 me-1" onclick="create_popup_header()">
                                New Header
                            </button>
                            <button type="button" class="btn btn-secondary col-6 col-lg-2 me-1" onclick="create_popup_content()">
                                New Content
                            </button>
                        </div>
                        <hr>
                        <div id="degree_course" name="degree_course" style="min-height: 50vh;">
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-2 col-12 rounded" style="padding: 0.5rem 0.25rem;">
                    <div class="bg-secondary">

                    </div>
                </div>
            </form>
        </div>
    </div>




    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-edit_course.html"; ?>
</body>

</html>