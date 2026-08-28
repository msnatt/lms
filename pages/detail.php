<?php
include '../components/session.php';
checkLogin();
$courseid = (int)($_GET['courseid'] ?? 0);
$user = $_SESSION['user'] ?? [];

// เดิมหน้านี้เชื่อ $_SESSION['course']/['owner'] ที่ set_course.php เซ็ตไว้ล้วนๆ โดยไม่ตรวจสอบซ้ำ
// เปลี่ยนมา query จาก $courseid ตรงๆ ทุกครั้งแทน ทำให้เปิด URL ตรงก็ทำงานถูกต้องเสมอ ไม่พึ่ง session
// state ที่มาจาก GET request ก่อนหน้า และเพิ่มการกรอง is_publish/is_deleted ให้ครบ
require_once '../config/connect.php';
$course = null;
if ($stmt = $conn->prepare("SELECT * FROM course WHERE id = ? AND is_deleted = 0")) {
    $stmt->bind_param("i", $courseid);
    $stmt->execute();
    $course = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
if (!$course) {
    header("Location: ../pages/course.php");
    exit();
}

$isAdmin = !empty($user['is_admin']);
$isOwner = (int)$course['create_by'] === (int)($user['id'] ?? 0);
if ((int)$course['is_publish'] !== 1 && !$isAdmin && !$isOwner) {
    header("Location: ../pages/course.php");
    exit();
}

$owner = null;
if ($stmt = $conn->prepare("SELECT id, name FROM user WHERE id = ?")) {
    $stmt->bind_param("i", $course['create_by']);
    $stmt->execute();
    $owner = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$isRegistered = false;
if (!$isAdmin && !$isOwner && !empty($user['id'])) {
    if ($stmt = $conn->prepare("SELECT id FROM course_student WHERE course_id = ? AND owner_id = ? AND is_deleted = 0")) {
        $uid = (int)$user['id'];
        $stmt->bind_param("ii", $courseid, $uid);
        $stmt->execute();
        $isRegistered = $stmt->get_result()->fetch_assoc() !== null;
        $stmt->close();
    }
}
$canSeeContent = $isAdmin || $isOwner || $isRegistered;
$canManageMembers = $isAdmin || $isOwner;
$conn->close();
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($course['name']) ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap">

                <div class="page-title">
                    <button onclick="window.history.back();" class="icon-btn"><i class="bi bi-arrow-left"></i></button>
                    <span class="page-title-icon"><i class="bi bi-journal-text"></i></span>
                    <h2 id="course-title"><?= htmlspecialchars($course['name']) ?></h2>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div id="content_course" class="degree-course" style="width: 100%;"></div>

                        <div id="content-locked" class="panel text-center d-none">
                            <p class="mb-3"><?= $lang['lockedcontent'] ?></p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="panel mb-3">
                            <div class="course-thumb mb-3">
                                <img id="course-thumb-img" alt="">
                            </div>
                            <button type="button" id="register_btn" class="btn btn-secondary w-100"></button>
                            <hr>
                            <h3><i class="bi bi-info-circle"></i><?= $lang['information'] ?></h3>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="text-muted"><?= $lang['createby'] ?></span>
                                <span id="course-owner"><?= htmlspecialchars($owner['name'] ?? '-') ?></span>
                            </div>
                            <p id="course-description" class="text-muted mb-0"></p>
                        </div>

                        <div class="panel mb-3">
                            <h3><i class="bi bi-bullseye"></i><?= $lang['obj'] ?></h3>
                            <p id="course-objective" class="mb-0"></p>
                        </div>

                        <div class="panel mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0"><i class="bi bi-people"></i><?= $lang['memberc'] ?></h3>
                                <span class="badge text-bg-light" id="member-count">0</span>
                            </div>
                            <div id="member-preview" class="mt-2"></div>
                            <?php if ($canManageMembers): ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#membersModal">
                                    <i class="bi bi-list-ul me-1"></i><?= $lang['allmember'] ?>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="panel-soft">
                            <h3><i class="bi bi-calendar-week"></i><?= $lang['timetable'] ?></h3>
                            <div id="calendar-info" class="mb-2"></div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <?php if ($isAdmin && $isOwner): ?>
                    <div style="position: fixed; bottom: 10%; right: 3%;">
                        <button class="menuquickly" onclick="window.location.href = '../pages/course_edit.php?courseid=<?php echo $courseid; ?>'">
                            <img src="../assets/images/edit.png" width="25px" height="25px" />
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php if ($canManageMembers): ?>
    <!-- Modal รายชื่อสมาชิก — เดิมแสดงเป็น panel ฝังอยู่ในหน้าตลอดเวลา เปลี่ยนเป็นซ่อนไว้ก่อน กดปุ่มถึงเปิดดู -->
    <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="membersModalLabel"><i class="bi bi-people me-1"></i><?= $lang['memberc'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="search_box" class="form-control mb-2" placeholder="<?= $lang['searchstudent'] ?>">
                    <div class="cert-table-wrap">
                        <table id="table_user">
                            <thead>
                                <tr>
                                    <th><?= $lang['name'] ?></th>
                                    <th><?= $lang['code'] ?></th>
                                    <th><?= $lang['roles'] ?></th>
                                    <th><?= $lang['action'] ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal ยืนยันการถอนสมาชิกออกจากคอร์ส (ไม่ลบบัญชีผู้ใช้) -->
    <div class="modal fade" id="removeStudentModal" tabindex="-1" aria-labelledby="removeStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeStudentModalLabel"><?= $lang['confirmremovestudent'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        <?= $lang['textconfirmremovestudent'] ?>
                        <strong id="removeStudentName"></strong>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" id="confirmRemoveStudentBtn"><?= $lang['removestudent'] ?></button>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <script id="page-data" type="application/json">
        <?= json_encode([
            'courseid' => $courseid,
            'is_admin' => $isAdmin,
            'can_see_content' => $canSeeContent,
            'can_manage_members' => $canManageMembers,
            'is_registered' => $isRegistered,
        ], JSON_UNESCAPED_UNICODE) ?>
    </script>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>
