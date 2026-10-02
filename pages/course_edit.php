<?php
include '../components/session.php';
checkLogin();

$courseid = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? (int) $_GET['courseid'] : 0;
$user = is_array($_SESSION['user'] ?? null) ? $_SESSION['user'] : [];
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['editcourse'] ?> - E-learning</title>

    <!-- Tailwind (scoped to course_edit.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        brand: '#0284c7',
                        brandink: '#0c4a6e'
                    }
                }
            }
        }
    </script>
    <style>
        /* input:focus ของ style.html ยังเป็นขอบส้มเดิม (ใช้ร่วมทั้งระบบ) ทับด้วยสีฟ้าของแบรนด์ใหม่เฉพาะหน้านี้ */
        #form-course .form-control:focus,
        #form-course .form-select:focus,
        #managebox .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">

            <!-- ACTION BAR -->
            <div class="tw-sticky tw-top-0 tw-z-20 tw-bg-white tw-border-b tw-border-slate-200 tw-shadow-sm">
                <div class="tw-w-full tw-px-4 lg:tw-px-8 tw-py-3 tw-flex tw-items-center tw-justify-between tw-gap-3">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-min-w-0">
                        <button type="button" onclick="window.history.back();" class="tw-inline-flex tw-items-center tw-justify-center tw-w-9 tw-h-9 tw-rounded-full tw-bg-slate-100 hover:tw-bg-slate-200 tw-border-0 tw-text-slate-600">
                            <i class="bi bi-arrow-left tw-text-lg"></i>
                        </button>
                        <div id="title_edit" class="tw-text-lg md:tw-text-xl tw-font-bold tw-text-brandink tw-truncate"><?= $lang['editcourse'] ?>&nbsp;</div>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2 tw-shrink-0">
                        <button type="button" onclick="update_course()" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-brand hover:tw-opacity-90 tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium">
                            <i class="bi bi-floppy-fill"></i> <span class="tw-hidden sm:tw-inline"><?= $lang['save'] ?></span>
                        </button>
                        <button type="button" onclick="window.history.back();" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-white hover:tw-bg-slate-50 tw-text-slate-600 tw-border tw-border-slate-300 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium">
                            <i class="bi bi-x-lg"></i> <span class="tw-hidden sm:tw-inline"><?= $lang['cancel'] ?></span>
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-red-600 hover:tw-bg-red-700 tw-text-white tw-border-0 tw-rounded-lg tw-px-4 tw-py-2 tw-text-sm tw-font-medium">
                            <i class="bi bi-trash"></i> <span class="tw-hidden sm:tw-inline"><?= $lang['delete'] ?></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="tw-w-full tw-px-4 lg:tw-px-8 tw-py-6">
                <form id="form-course" class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-12 tw-gap-4">
                    <input type="hidden" id="course_id" name="course_id" value="<?php echo $courseid; ?>">
                    <input type="hidden" id="is_deleted" name="is_deleted" value="0">

                    <!-- LEFT: course details -->
                    <section class="lg:tw-col-span-3 tw-bg-white tw-rounded-xl tw-shadow tw-p-5">
                        <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-4">
                            <i class="bi bi-info-circle"></i> <?= $lang['courseinfo'] ?>
                        </h2>

                        <div class="tw-relative tw-mb-3">
                            <img id="img-course" class="tw-w-full tw-h-44 tw-object-cover tw-rounded-lg tw-bg-slate-100" alt="">
                            <button type="button" onclick="toggleEditImage()" class="tw-absolute tw-top-2 tw-right-2 tw-inline-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-full tw-bg-white/90 hover:tw-bg-white tw-border-0 tw-text-slate-700 tw-shadow">
                                <i class="bi bi-pen"></i>
                            </button>
                        </div>

                        <div id="edit-img" class="w-100 d-none tw-mb-3 tw-p-3 tw-rounded-lg tw-bg-slate-50 tw-border tw-border-slate-200">
                            <label class="tw-block tw-text-sm tw-text-slate-600 tw-mb-1"><?= $lang['select'] . $lang['image'] ?></label>
                            <select id="image_code" name="image_code" class="form-select" onchange="changeImage()"></select>
                            <label class="tw-block tw-text-sm tw-text-slate-600 tw-mt-3 tw-mb-1"><?= $lang['upload'] . $lang['new'] . $lang['image'] ?></label>
                            <button type="button" id="manage" class="tw-w-full tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-bg-white hover:tw-bg-slate-100 tw-border tw-border-slate-300 tw-rounded-lg tw-px-3 tw-py-2 tw-text-sm">
                                <?= $lang['upload'] ?> <i class="bi bi-cloud-plus tw-text-lg"></i>
                            </button>
                        </div>

                        <div class="tw-grid tw-grid-cols-2 tw-gap-3 tw-mb-3">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['namecourse'] ?></label>
                                <input type="text" id="name_course" name="name_course" class="form-control">
                            </div>
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['codecourse'] ?></label>
                                <input type="text" id="code_course" name="code_course" class="form-control" oninput="validateNumberInput(event)">
                            </div>
                        </div>

                        <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['description'] ?><?= $lang['course'] ?></label>
                        <textarea id="textBoxDescription" name="textBoxDescription" rows="4" class="form-control tw-mb-3"></textarea>

                        <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['obj'] ?></label>
                        <textarea id="textBoxObjective" name="textBoxObjective" rows="4" class="form-control"></textarea>
                    </section>

                    <!-- MIDDLE: curriculum builder -->
                    <section class="lg:tw-col-span-6 tw-bg-white tw-rounded-xl tw-shadow tw-p-5">
                        <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-2 tw-mb-4">
                            <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-0">
                                <i class="bi bi-list-check"></i> <?= $lang['coursecontent'] ?>
                            </h2>
                            <div class="tw-flex tw-gap-2">
                                <button type="button" onclick="create_popup_header()" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-slate-100 hover:tw-bg-slate-200 tw-text-slate-700 tw-border-0 tw-rounded-lg tw-px-3 tw-py-2 tw-text-sm tw-font-medium">
                                    <i class="bi bi-plus-lg"></i> <?= $lang['n-header'] ?>
                                </button>
                                <button type="button" onclick="create_popup_content()" class="tw-inline-flex tw-items-center tw-gap-1 tw-bg-slate-100 hover:tw-bg-slate-200 tw-text-slate-700 tw-border-0 tw-rounded-lg tw-px-3 tw-py-2 tw-text-sm tw-font-medium">
                                    <i class="bi bi-plus-lg"></i> <?= $lang['n-content'] ?>
                                </button>
                            </div>
                        </div>
                        <div id="degree_course" name="degree_course" class="tw-flex tw-flex-col tw-gap-2" style="min-height: 50vh;"></div>
                    </section>

                    <!-- RIGHT: settings + schedule -->
                    <section class="lg:tw-col-span-3 tw-flex tw-flex-col tw-gap-4">
                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-5">
                            <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-4">
                                <i class="bi bi-gear"></i> <?= $lang['status'] ?>
                            </h2>

                            <div class="tw-flex tw-items-center tw-mb-4">
                                <div class="form-check form-switch px-3">
                                    <input class="form-check-input ms-0 switch-lg" type="checkbox" id="is_publish" name="is_publish">
                                </div>
                                <label class="tw-font-semibold tw-text-slate-700 tw-mb-0" for="is_publish"><?= $lang['publish'] ?></label>
                            </div>

                            <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['faculty'] ?></label>
                            <select class="form-select tw-mb-3" name="select_faculty" id="select_faculty">
                                <option value=""><?= $lang['all_faculty'] ?? '-- All Faculty --' ?></option>
                                <option value="1"><?= $lang['science'] ?? 'Faculty of Science' ?></option>
                                <option value="2"><?= $lang['engineering'] ?? 'Faculty of Engineering' ?></option>
                                <option value="3"><?= $lang['business'] ?? 'Faculty of Business Administration' ?></option>
                                <option value="4"><?= $lang['arts'] ?? 'Faculty of Arts' ?></option>
                                <option value="5"><?= $lang['medicine'] ?? 'Faculty of Medicine' ?></option>
                            </select>

                            <label class="tw-block tw-text-sm tw-font-medium tw-text-slate-600 tw-mb-1"><?= $lang['department'] ?></label>
                            <select class="form-select" name="select_department" id="select_department">
                                <option value=""><?= $lang['all_department'] ?? '-- All Department --' ?></option>
                                <optgroup label="<?= $lang['science'] ?? 'Faculty of Science' ?>">
                                    <option value="1"><?= $lang['cs'] ?? 'Computer Science' ?></option>
                                    <option value="2"><?= $lang['math'] ?? 'Mathematics' ?></option>
                                    <option value="3"><?= $lang['physics'] ?? 'Physics' ?></option>
                                    <option value="4"><?= $lang['chemistry'] ?? 'Chemistry' ?></option>
                                    <option value="5"><?= $lang['biology'] ?? 'Biology' ?></option>
                                </optgroup>
                                <optgroup label="<?= $lang['engineering'] ?? 'Faculty of Engineering' ?>">
                                    <option value="10"><?= $lang['civil'] ?? 'Civil Engineering' ?></option>
                                    <option value="11"><?= $lang['mechanical'] ?? 'Mechanical Engineering' ?></option>
                                    <option value="12"><?= $lang['electrical'] ?? 'Electrical Engineering' ?></option>
                                    <option value="13"><?= $lang['computer_eng'] ?? 'Computer Engineering' ?></option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="tw-bg-white tw-rounded-xl tw-shadow tw-p-5">
                            <div class="tw-flex tw-items-center tw-justify-between tw-mb-3">
                                <h2 class="tw-flex tw-items-center tw-gap-2 tw-text-base tw-font-bold tw-text-brandink tw-mb-0">
                                    <i class="bi bi-calendar-week"></i> <?= $lang['schedule'] ?>
                                </h2>
                                <input type="button" id="btn_schedule" value="+" class="tw-inline-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 tw-text-lg tw-leading-none">
                            </div>
                            <div id="div_schedule" class="tw-flex tw-flex-col tw-gap-2"></div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>

    <!-- Image manager (fixed slide-in panel, controlled by #manage via style.html's #managebox.show) -->
    <div id="managebox" class="bg-white rounded p-3">
        <h3 class="text-center"><?= $lang['manageimage'] ?></h3>
        <div id="preview" class="w-100 text-center" style="display: none;">
            <p class="text-center mb-0 fw-bold"><?= $lang['preview'] ?></p>
            <img id="img-preview" src="#" alt="Image Preview" style="max-height: 200px;">
        </div>
        <button class="btn btn-success mx-auto my-2 w-25" id="btn-save" onclick="saveto()" style="display: none;"><?= $lang['save'] ?></button>
        <div class="w-100 px-4 py-2">
            <label for="imageInput" class="upload-box w-100">
                <p><?= $lang['clickforimport'] ?></p>
                <input type="file" id="imageInput" accept="image/*" style="display: none;">
            </label>
        </div>
    </div>

    <!-- Modal: ยืนยันการลบคอร์ส -->
    <div class="modal fade" id="confirm-delete-modal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel"><?= $lang['confirm'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0"><?= $lang['confirmdelete'] ?> <strong><?= $lang['editcourse'] ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['cancel'] ?></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="is_deleted_course()"><?= $lang['delete'] ?></button>
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
