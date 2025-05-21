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
    <meta charset="UTF-8">
    <title><?= $lang['createcourse'] ?> - E-learning</title>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <div class="d-flex" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="bg-light p-4 w-100" style="min-height: 60vh; ">
                <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                <span id="title_edit" style="font-size: 2rem; font-weight: 600;"><?= $lang['createcourse'] ?></span>
                <div class="d-flex justify-content-center ">
                    <form id="form-course" class="d-flex flex-wrap w-75" style="min-width: 85%;">
                        <input type="hidden" id="is_deleted" name="is_deleted" value="0">
                        <div class="d-flex flex-column col-lg-3 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                            <div class="bg-secondary p-4 rounded bg-opacity-10">
                                <div class="d-flex">
                                    <div>
                                        <label class="form-label"><?= $lang['namecourse'] ?></label>
                                        <input type="text" id="name_course" name="name_course" class="form-control">
                                    </div>
                                    <div>
                                        <label class="form-label"><?= $lang['codecourse'] ?></label>
                                        <input type="text" id="code_course" name="code_course" class="form-control" oninput="validateNumberInput(event)">
                                    </div>
                                </div>
                                <label class="form-label"><?= $lang['description'] ?></label>
                                <textarea id="textBoxDescription" name="textBoxDescription" rows="4" cols="50" class="form-control"></textarea>
                                <label class="form-label"><?= $lang['obj'] ?></label>
                                <textarea id="textBoxObjective" name="textBoxObjective" rows="4" cols="50" class="form-control"></textarea>
                                <div class="mt-5 d-flex g-5 justify-content-around">
                                    <button type="button" class="btn btn-primary" onclick="create_course()" style="width: 40%;">
                                        <?= $lang['create'] ?>
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="" style="width: 40%;">
                                        <?= $lang['cancel'] ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column col-lg-7 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                            <div class="bg-secondary p-2 rounded bg-opacity-10">
                                <div class="p-1 rounded d-flex justify-content-center gap-3 ">
                                    <button type="button" class="btn btn-secondary" onclick="create_popup_header()">
                                        <?= $lang['n-header'] ?>
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="create_popup_content()">
                                        <?= $lang['n-content'] ?>
                                    </button>
                                </div>
                                <hr>
                                <div id="degree_course" name="degree_course" style="min-height: 50vh;">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column col-lg-2 col-12 rounded" style="padding: 0.2rem 0.25rem;">
                            <div class="bg-secondary p-2 rounded bg-opacity-10">
                                <h5 class="d-flex justify-content-center"><?= $lang['status'] ?></h5>
                                <div class="d-flex mb-3">
                                    <div class="form-check form-switch px-3">
                                        <input class="form-check-input ms-0 switch-lg" type="checkbox" id="is_publish" name="is_publish" checked>
                                    </div>
                                    <label class="fw-bold pe-4" for="largeSwitch"><?= $lang['publish'] ?></label>
                                </div>
                                <h5 class="d-flex justify-content-center"><?= $lang['detail'] ?></h5>
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
                            <div class="bg-secondary w-100 bg-opacity-10 rounded mt-1">
                                <h5 class="d-flex justify-content-center" style="position: relative;">
                                    <?= $lang['schedule']?>
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
    </div>




    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-course_create.html"; ?>
</body>

</html>