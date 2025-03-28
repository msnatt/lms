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
        <div class="bg-light main-container d-flex">
            <div class="sidebar" id="sidebar">
                <ul class="navbar-nav">
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-house"></i>
                        <span><a class="nav-link active text" href="../pages/home.php">Home</a></span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <a class="nav-link text" href="../pages/course.php">Course</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <a class="nav-link text" href="../pages/chat.php">Chat</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <a class="nav-link text" href="../pages/news.php">News</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <a class="nav-link text" href="../pages/contect.php">Contact us</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="p-4">Courses</h2>
                <div class="d-flex">
                    <div class="d-flex flex-column col-lg-3 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                        <div class="p-4 rounded bg-opacity-10" style="min-height: 100%;">
                            <div class="d-flex">
                                <div>
                                    <label class="form-label">Code</label>
                                    <input type="text" id="name_course" name="name_course" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Name</label>
                                    <input type="text" id="code_course" name="code_course" class="form-control" oninput="validateNumberInput(event)">
                                </div>
                            </div>
                            <label class="form-label">Faculty</label>
                            <select class="form-select" name="select_faculty" id="select_faculty">
                                <option value="">-- Select Faculty --</option>
                                <option value="science">Faculty of Science</option>
                                <option value="engineering">Faculty of Engineering</option>
                                <option value="business">Faculty of Business Administration</option>
                                <option value="arts">Faculty of Arts</option>
                                <option value="medicine">Faculty of Medicine</option>
                            </select>

                            <label class="form-label">Department</label>
                            <select class="form-select" name="select_department" id="select_department">
                                <option value="">-- Select Department --</option>

                                <!-- Science Departments -->
                                <optgroup label="Faculty of Science">
                                    <option value="cs">Computer Science</option>
                                    <option value="math">Mathematics</option>
                                    <option value="physics">Physics</option>
                                    <option value="chemistry">Chemistry</option>
                                    <option value="biology">Biology</option>
                                </optgroup>

                                <!-- Engineering Departments -->
                                <optgroup label="Faculty of Engineering">
                                    <option value="civil">Civil Engineering</option>
                                    <option value="mechanical">Mechanical Engineering</option>
                                    <option value="electrical">Electrical Engineering</option>
                                    <option value="computer_eng">Computer Engineering</option>
                                </optgroup>

                                <!-- Business Departments -->
                                <optgroup label="Faculty of Business Administration">
                                    <option value="accounting">Accounting</option>
                                    <option value="finance">Finance</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="management">Management</option>
                                </optgroup>

                                <!-- Arts Departments -->
                                <optgroup label="Faculty of Arts">
                                    <option value="history">History</option>
                                    <option value="philosophy">Philosophy</option>
                                    <option value="literature">Literature</option>
                                    <option value="languages">Languages</option>
                                </optgroup>

                                <!-- Medicine Departments -->
                                <optgroup label="Faculty of Medicine">
                                    <option value="general_medicine">General Medicine</option>
                                    <option value="dentistry">Dentistry</option>
                                    <option value="pharmacy">Pharmacy</option>
                                    <option value="nursing">Nursing</option>
                                </optgroup>
                            </select>

                            <div class="mt-5 d-flex g-5 justify-content-around">
                                <button type="button" class="btn btn-danger" onclick="" style="width: 40%;">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
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