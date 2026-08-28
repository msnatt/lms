<?php
include '../components/session.php';
checkLogin();
$courseid = (int)($_GET['courseid'] ?? 0);
$user = $_SESSION['user'] ?? 'N/A';

// ตรวจสิทธิ์: ต้องเป็น admin หรือเจ้าของคอร์ส (create_by) เท่านั้นถึงเปิดหน้าแก้ไขนี้ได้
// เดิมหน้านี้ไม่มีการเช็คสิทธิ์เลย พิมพ์ URL พร้อม courseid ตรงเข้าได้ทุกบัญชี
require_once '../config/connect.php';
$course_row = null;
if ($stmt = $conn->prepare("SELECT create_by FROM course WHERE id = ? AND is_deleted = 0")) {
    $stmt->bind_param("i", $courseid);
    $stmt->execute();
    $course_row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
if (!$course_row) {
    header("Location: ../pages/course.php");
    exit();
}
$isAdmin = !empty($user['is_admin']);
$isOwner = (int)$course_row['create_by'] === (int)($user['id'] ?? 0);
if (!$isAdmin && !$isOwner) {
    header("Location: ../pages/home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['editcourse'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap" style="max-width: 1400px;">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-journal-text"></i></span>
                    <h2 id="title_edit"><?= $lang['editcourse'] ?> </h2>
                    <div class="ms-auto d-flex gap-2">
                        <button type="button" class="btn btn-primary" onclick="update_course()">
                            <i class="bi bi-floppy-fill me-1"></i><?= $lang['save'] ?>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back();">
                            <?= $lang['cancel'] ?>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="is_deleted_course()">
                            <i class="bi bi-trash me-1"></i><?= $lang['delete'] ?>
                        </button>
                    </div>
                </div>

                <form id="form-course" class="row g-3">
                    <input type="hidden" id="course_id" name="course_id" value="<?php echo $courseid; ?>">
                    <input type="hidden" id="is_deleted" name="is_deleted" value="0">

                    <!-- Basic info -->
                    <div class="col-12 col-lg-3">
                        <div class="panel">
                            <div class="course-thumb">
                                <img id="img-course" alt="">
                                <button type="button" class="course-thumb-edit" onclick="toggleEditImage()"><i class="bi bi-pen"></i></button>
                            </div>

                            <div id="edit-img" class="d-none mt-3">
                                <label class="form-label"><?= $lang['select'] . $lang['image'] ?></label>
                                <select id="image_code" name="image_code" class="form-select" onchange="changeImage()"></select>
                                <label class="form-label"><?= $lang['upload'] . $lang['new'] . $lang['image'] ?></label>
                                <button type="button" id="manage" class="btn btn-outline-secondary w-100">
                                    <?= $lang['upload'] ?> <i class="bi bi-cloud-plus"></i>
                                </button>
                            </div>

                            <hr>

                            <label class="form-label"><?= $lang['namecourse'] ?></label>
                            <input type="text" id="name_course" name="name_course" class="form-control">

                            <label class="form-label"><?= $lang['codecourse'] ?></label>
                            <input type="text" id="code_course" name="code_course" class="form-control" oninput="validateNumberInput(event)">

                            <label class="form-label"><?= $lang['description'] ?><?= $lang['course'] ?></label>
                            <textarea id="textBoxDescription" name="textBoxDescription" rows="4" class="form-control"></textarea>

                            <label class="form-label"><?= $lang['obj'] ?></label>
                            <textarea id="textBoxObjective" name="textBoxObjective" rows="4" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Content builder -->
                    <div class="col-12 col-lg-6">
                        <div class="panel h-100 d-flex flex-column">
                            <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="create_popup_header()">
                                    <i class="bi bi-plus-square me-1"></i><?= $lang['n-header'] ?>
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="create_popup_content()">
                                    <i class="bi bi-file-earmark-plus me-1"></i><?= $lang['n-content'] ?>
                                </button>
                            </div>
                            <div id="degree_course" name="degree_course" class="degree-course flex-grow-1"></div>
                        </div>
                    </div>

                    <!-- Status / schedule -->
                    <div class="col-12 col-lg-3">
                        <div class="panel mb-3">
                            <h3><i class="bi bi-toggles"></i><?= $lang['status'] ?></h3>
                            <div class="form-check form-switch d-flex align-items-center gap-2 mb-3">
                                <input class="form-check-input switch-lg m-0" type="checkbox" id="is_publish" name="is_publish">
                                <label class="fw-semibold mb-0" for="is_publish"><?= $lang['publish'] ?></label>
                            </div>

                            <h3><i class="bi bi-info-circle"></i><?= $lang['detail'] ?></h3>
                            <label class="form-label"><?= $lang['faculty'] ?></label>
                            <select class="form-select" name="select_faculty" id="select_faculty"></select>

                            <label class="form-label"><?= $lang['department'] ?></label>
                            <select class="form-select" name="select_department" id="select_department"></select>
                        </div>

                        <div class="panel-soft">
                            <h3>
                                <i class="bi bi-calendar-week"></i><?= $lang['schedule'] ?>
                                <input type="button" id="btn_schedule" value="+" class="icon-btn" style="position: absolute; top: -0.25rem; right: 0; width: 32px; height: 32px;">
                            </h3>
                            <div id="div_schedule"></div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="managebox">
        <h3 class="text-center"><?= $lang['manageimage'] ?></h3>
        <div id="preview" class="w-100 text-center" style="display: none;">
            <p class="text-center mb-0 fw-bold"><?= $lang['preview'] ?></p>
            <img id="img-preview" src="#" alt="Image Preview" style="max-height: 200px;">
        </div>
        <button class="btn btn-success mx-auto my-2 w-25 d-block" id="btn-save" onclick="saveto()" style="display: none;"><?= $lang['save'] ?></button>
        <div class="w-100 px-4 py-2">
            <label for="imageInput" class="upload-box w-100">
                <p><?= $lang['clickforimport'] ?></p>
                <input type="file" id="imageInput" accept="image/*" style="display: none;">
            </label>
        </div>
    </div>

    <!-- Modal ยืนยันการลบคอร์ส -->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCourseModalLabel"><?= $lang['confirmdeletecourse'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0"><?= $lang['textconfirmdeletecourse'] ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteCourseBtn" onclick="confirmDeleteCourse()"><?= $lang['delete'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-edit_course.html"; ?>
</body>

</html>
