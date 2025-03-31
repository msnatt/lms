<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<style>
    #search_box {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.098zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>') no-repeat 10px center;
        background-size: 16px;
        padding-left: 35px;
    }
</style>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4" style="max-width: 100%">Courses</h2>
                <div class="d-flex">
                    <div class="d-flex flex-column col-lg-2 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                        <div class="p-4 rounded bg-opacity-10" style="min-height: 100%;">
                            <div>
                                <label class="form-label">Code</label>
                                <input type="text" id="code_filter" name="code_filter" class="form-control" oninput="validateNumberInput(event) ">
                            </div>
                            <div>
                                <label class="form-label">Name</label>
                                <input type="text" id="name_filter" name="name_filter" class="form-control" oninput="filterCourses()">
                            </div>
                            <label class="form-label">Faculty</label>
                            <select class="form-select" name="select_faculty" id="select_faculty" onchange="filterCourses()">
                                <option value="">-- All Faculty --</option>
                                <option value="1">Faculty of Science</option>
                                <option value="2">Faculty of Engineering</option>
                                <option value="3">Faculty of Business Administration</option>
                                <option value="4">Faculty of Arts</option>
                                <option value="5">Faculty of Medicine</option>
                            </select>

                            <label class="form-label">Department</label>
                            <select class="form-select" name="select_department" id="select_department" onchange="filterCourses()">
                                <option value="">-- All Department --</option>

                                <!-- Science Departments -->
                                <optgroup label="Faculty of Science">
                                    <option value="1">Computer Science</option>
                                    <option value="2">Mathematics</option>
                                    <option value="3">Physics</option>
                                    <option value="4">Chemistry</option>
                                    <option value="5">Biology</option>
                                </optgroup>

                                <!-- Engineering Departments -->
                                <optgroup label="Faculty of Engineering">
                                    <option value="10">Civil Engineering</option>
                                    <option value="11">Mechanical Engineering</option>
                                    <option value="12">Electrical Engineering</option>
                                    <option value="13">Computer Engineering</option>
                                </optgroup>
                            </select>

                            <div class="mt-5 d-flex g-5 justify-content-around">
                                <button type="button" class="btn btn-danger" onclick="" style="width: 40%;">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="d-flex justify-content-center px-4">
                            <input type="text" id="search_box" name="search_box" class="form-control" height="60px" placeholder="search course you interest!">
                        </div>
                        <div class="d-flex justify-content-between px-4 pt-3">
                            <div>
                                Number of search results :
                                <span id="numofresult"></span>
                            </div>
                            <div>
                                <button type="button" class="form-control"><i class="bi bi-arrow-clockwise"></i>refresh</button>
                            </div>
                        </div>
                        <div id="course_div" name="course_div" class="d-flex flex-wrap justify-content-center"></div>

                        <br>
                        <br>
                        <!-- Pagination -->
                        <div class="pagination mt-4">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-center">
                                    <button class="page-link" id="prev-page" disabled>&lt;</button>
                                </div>
                                <div class="col-4 d-flex justify-content-center align-items-center">
                                    <span class="page-link" id="current-page">1</span> / <span id="total-pages">1</span>
                                </div>
                                <div class="col-4 d-flex justify-content-center">
                                    <button class="page-link" id="next-page">&gt;</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <?php if ($user['is_admin'] == "1"): ?>
                            <div style="position: fixed; bottom: 10%; right: 3%;">
                                <button class="menuquickly" onclick="window.location.href = '../pages/course_create.php'">
                                    <img src="../assets/images/add.png" width="25px" height="25px" />
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course.html"; ?>
</body>

</html>