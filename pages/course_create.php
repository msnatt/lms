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
    <div class="main-inner">

        <div class="bg-light main-container p-4 mt-2" style="min-height: 60vh;">
            <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
            <span id="title_edit" style="font-size: 2rem; font-weight: 600;">New Course</span>
            <div class="d-flex"> <!-- ใช้ gap แทน margin -->
                <div class="d-flex flex-column col-lg-3 col-12 p-4 rounded" style="background-color: #eee;">
                    <form id="form-course">
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
                            <button type="button" class="btn btn-primary" onclick="create_course()" style="width: 40%;">
                                Create
                            </button>
                            <button type="button" class="btn btn-danger" onclick="" style="width: 40%;">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-column col-lg-7 col-12 rounded" style="padding: 0rem .75rem;">
                    <div class="bg-secondary p-2 rounded bg-opacity-10">
                        <div class="p-3 rounded">
                            <button type="button" class="btn btn-secondary" onclick="create_popup_header()">
                                New Header
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="create_popup_content()">
                                New Content
                            </button>
                        </div>
                        <hr>
                        <div id="degree_course" name="degree_course" style="min-height: 50vh;">
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-2 col-12 p-4 rounded bg-opacity-10 bg-secondary">
                </div>
            </div>
        </div>
    </div>




    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course_create.html"; ?>
</body>

</html>