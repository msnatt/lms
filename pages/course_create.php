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
        <div class="main-container">
            <h3 class="p-4">New Course</h3>
        </div>

        <div class="bg-light main-container p-4" style="min-height: 60vh;">
            <div class="d-flex"> <!-- ใช้ gap แทน margin -->
                <div class="d-flex flex-column col-lg-3 col-12 p-4 rounded" style="background-color: #eee;">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control">
                    <label class="form-label">Objective</label>
                    <input type="text" class="form-control">
                </div>
                <div class="d-flex flex-column col-lg-7 col-12 rounded" style="padding: 0rem .75rem;">
                    <div class="bg-secondary p-2 rounded bg-opacity-10">
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#headerModal">
                                New Header
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#contentModal">
                                New Content
                            </button>
                        </div>
                        <div id="degree_course" name="degree_course" style="min-height: 50vh;">
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-2 col-12 p-4 rounded bg-opacity-10 bg-secondary">
                </div>
            </div>
        </div>
    </div>

    <!-- header popup -->
    <div class="modal fade" id="headerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 50vw;">
            <div class="modal-content" style="min-height: 70vh;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Header</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="select_header">
                        
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- content popup -->
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Header</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="select_content" class="form-select">
                        <option value="0">please select type</option>
                    </select>
                    <div id="contentofcontent">
                        <!-- content in js -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
        <?php include "../include/scriptjs-course-create.html"; ?>
</body>

</html>