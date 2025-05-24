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
    <title><?= $lang['course'] ?> - E-learning</title>
</head>
<style>
    #search_box {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.098zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>') no-repeat 10px center;
        background-size: 16px;
        padding-left: 35px;
    }
</style>


<body>
    <?php include "../include/header.php"; ?>

    <div class=" d-flex bg-light bg-opacity-75">
        <div class=" d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4 text-center" style="max-width: 100%"><?= $lang['allcourse'] ?></h2>
                <div class="d-flex">
                    <div class="d-flex flex-wrap w-100 rounded" style="padding: 0.2rem 0.25rem;">
                        <div id="filter-box" class="d-flex flex-column col-12 col-lg-2 px-4 rounded">
                            <div class="d-flex g-5 justify-content-around">
                                <h3><i class="bi bi-funnel-fill"></i><?= $lang['filter'] ?></h3>
                            </div>
                            <div>
                                <label class="form-label"><?= $lang['codecourse'] ?></label>
                                <input type="text" id="code_filter" name="code_filter" class="form-control" oninput="validateNumberInput(event)" placeholder=<?= $lang['entercode'] ?>>
                            </div>
                            <div>
                                <label class="form-label"><?= $lang['namecourse'] ?></label>
                                <input type="text" id="name_filter" name="name_filter" class="form-control" oninput="filterCourses()" placeholder=<?= $lang['entername'] ?>>
                            </div>
                            <label class="form-label"><?= $lang['faculty'] ?></label>
                            <select class="form-select" name="select_faculty" id="select_faculty" onchange="filterCourses()">
                                <option value=""><?= $lang['all_faculty'] ?? '-- All Faculty --' ?></option>
                                <option value="1"><?= $lang['science'] ?? 'Faculty of Science' ?></option>
                                <option value="2"><?= $lang['engineering'] ?? 'Faculty of Engineering' ?></option>
                                <option value="3"><?= $lang['business'] ?? 'Faculty of Business Administration' ?></option>
                                <option value="4"><?= $lang['arts'] ?? 'Faculty of Arts' ?></option>
                                <option value="5"><?= $lang['medicine'] ?? 'Faculty of Medicine' ?></option>
                            </select>

                            <label class="form-label"><?= $lang['department'] ?></label>
                            <select class="form-select" name="select_department" id="select_department" onchange="filterCourses()">
                                <option value=""><?= $lang['all_department'] ?? '-- All Department --' ?></option>

                                <!-- Science Departments -->
                                <optgroup label="<?= $lang['science'] ?? 'Faculty of Science' ?>">
                                    <option value="1"><?= $lang['cs'] ?? 'Computer Science' ?></option>
                                    <option value="2"><?= $lang['math'] ?? 'Mathematics' ?></option>
                                    <option value="3"><?= $lang['physics'] ?? 'Physics' ?></option>
                                    <option value="4"><?= $lang['chemistry'] ?? 'Chemistry' ?></option>
                                    <option value="5"><?= $lang['biology'] ?? 'Biology' ?></option>
                                </optgroup>

                                <!-- Engineering Departments -->
                                <optgroup label="<?= $lang['engineering'] ?? 'Faculty of Engineering' ?>">
                                    <option value="10"><?= $lang['civil'] ?? 'Civil Engineering' ?></option>
                                    <option value="11"><?= $lang['mechanical'] ?? 'Mechanical Engineering' ?></option>
                                    <option value="12"><?= $lang['electrical'] ?? 'Electrical Engineering' ?></option>
                                    <option value="13"><?= $lang['computer_eng'] ?? 'Computer Engineering' ?></option>
                                </optgroup>
                            </select>

                        </div>
                        <div id="result-box" class="d-flex flex-column col-12 col-lg-10">
                            <div class="d-flex justify-content-center px-4">
                                <input type="text" id="search_box" name="search_box" class="form-control" height="60px" placeholder=<?= $lang['entersearch'] ?>>
                            </div>
                            <div class="d-flex justify-content-between px-4 pt-3">
                                <div>
                                    <?= $lang['numofresult'] ?> :
                                    <span id="numofresult"></span>
                                </div>
                                <div>
                                    <button type="button" class="form-control"><i class="bi bi-arrow-clockwise"></i><?= $lang['refresh'] ?></button>
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
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course.html"; ?>
</body>

</html>