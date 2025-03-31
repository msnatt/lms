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

        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="bg-light main-container p-4 w-100" style="min-height: 60vh;">
                <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                <span id="title_edit" style="font-size: 2rem; font-weight: 600;">Edit Course</span>
                <form id="form-course" class="d-flex flex-wrap">
                    <input type="hidden" id="course_id" name="course_id" value="<?php echo $courseid; ?>">
                    <input type="hidden" id="is_deleted" name="is_deleted" value="0">
                    <div class="d-flex flex-column col-lg-3 col-12 rounded" style="padding: 0.2rem 0.25rem;">
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
                    <div class="d-flex flex-column col-lg-7 col-12 rounded" style="padding: 0.2rem 0.25rem;">
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
                    <div class="d-flex flex-column col-lg-2 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                        <div class="bg-secondary p-2 rounded bg-opacity-10">
                            <div class="d-flex mb-3">
                                <div class="form-check form-switch px-3">
                                    <input class="form-check-input ms-0 switch-lg" type="checkbox" id="is_publish" name="is_publish">
                                </div>
                                <label class="fw-bold pe-4" for="largeSwitch">Publish now</label>
                            </div>
                            <label class="form-label">Faculty</label>
                            <select class="form-select" required name="select_faculty" id="select_faculty">
                                <option value="1">-- All Faculty --</option>
                                <option value="2">Faculty of Science</option>
                                <option value="3">Faculty of Engineering</option>
                                <option value="4">Faculty of Business Administration</option>
                                <option value="5">Faculty of Arts</option>
                                <option value="6">Faculty of Medicine</option>
                            </select>

                            <label class="form-label">Department</label>
                            <select class="form-select" required name="select_department" id="select_department">
                                <option value="1">-- All Department --</option>

                                <!-- Science Departments -->
                                <optgroup label="Faculty of Science">
                                    <option value="2">Computer Science</option>
                                    <option value="3">Mathematics</option>
                                    <option value="4">Physics</option>
                                    <option value="5">Chemistry</option>
                                    <option value="6">Biology</option>
                                </optgroup>

                                <!-- Engineering Departments -->
                                <optgroup label="Faculty of Engineering">
                                    <option value="10">Civil Engineering</option>
                                    <option value="11">Mechanical Engineering</option>
                                    <option value="12">Electrical Engineering</option>
                                    <option value="13">Computer Engineering</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="bg-secondary w-100 bg-opacity-10 rounded mt-1">
                            <h5 class="d-flex justify-content-center" style="position: relative;">
                                Schedule
                                <input type="button" id="btn_schedule" value="+" class="btn btn-sm py-0 h-100" style="position: absolute; top: 0; right: 0; "></input>
                            </h5>
                            <div id="div_schedule">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-edit_course.html"; ?>
</body>

</html>