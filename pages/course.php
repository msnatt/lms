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


<body>
    <?php include "../include/header.php"; ?>

    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-journal-text"></i></span>
                    <h2><?= $lang['allcourse'] ?></h2>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-3">
                        <div class="filter-card" id="filter-box">
                            <h3><i class="bi bi-funnel-fill"></i><?= $lang['filter'] ?></h3>

                            <label class="form-label"><?= $lang['codecourse'] ?></label>
                            <input type="text" id="code_filter" name="code_filter" class="form-control" oninput="validateNumberInput(event)" placeholder="<?= $lang['entercode'] ?>">

                            <label class="form-label"><?= $lang['namecourse'] ?></label>
                            <input type="text" id="name_filter" name="name_filter" class="form-control" oninput="filterCourses()" placeholder="<?= $lang['entername'] ?>">

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
                    </div>

                    <div class="col-12 col-lg-9" id="result-box">
                        <div class="toolbar">
                            <div><?= $lang['numofresult'] ?>: <strong id="numofresult"></strong></div>
                            <button type="button" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i><?= $lang['refresh'] ?>
                            </button>
                        </div>

                        <div id="course_div" name="course_div" class="d-flex flex-wrap justify-content-center" style="min-height: 40svh;">
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <div class="col-12 col-md-6 col-xxl-3 d-flex justify-content-center" style="padding:1.5rem 0rem;">
                                    <div class="skeleton-card">
                                        <div class="skeleton-img"></div>
                                        <div class="dash-skeleton">
                                            <div class="dash-skeleton-line" style="width:70%; height:16px;"></div>
                                            <div class="dash-skeleton-line" style="width:90%;"></div>
                                            <div class="dash-skeleton-line" style="width:60%;"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="pagination-bar">
                            <button class="page-link" id="prev-page" disabled><i class="bi bi-chevron-left"></i></button>
                            <span><span class="fw-semibold" id="current-page">1</span> / <span id="total-pages">1</span></span>
                            <button class="page-link" id="next-page"><i class="bi bi-chevron-right"></i></button>
                        </div>

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
