<div class="sidebar collapsed" id="sidebar" style="border-right: 1px solid #aaa; transition: width 0.3s ease, padding 0.3s ease; background-color: <?=$bgside;?>;">
    <ul class="navbar-nav">
        <li class="gap-2 d-block d-lg-none">
            <button class="btn btn-link nav-link text px-0" data-bs-toggle="collapse" data-bs-target="#systemSubNav" aria-expanded="false">
                <?= $lang['hi'] ?>! <?= $_SESSION['username'] ?? '' ?>
            </button>
            <ul class="collapse nav flex-column " id="systemSubNav">
                <li class="d-flex align-items-start gap-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <a class="nav-secondary text" href="../pages/logout.php"><?= $lang['logout'] ?></a>
                </li>
            </ul>
            <hr>
        </li>
        <ul class="navbar-nav d-block d-lg-none">
            <li class="d-flex align-items-center gap-1">
                <!-- <i class="bi bi-house"></i> -->
                <a class="nav-link text" href="../pages/home.php"><?= $lang['home'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-1">
                <!-- <i class="bi bi-journal-text"></i> -->
                <a class="nav-link text" href="../pages/course.php"><?= $lang['course'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-1">
                <!-- <i class="bi bi-book-half"></i> -->
                <a class="nav-link text" href="../pages/course_catalogue.php"><?= $lang['catalogue'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-1">
                <a class="nav-link text" href="../pages/contect.php"><?= $lang['contact'] ?></a>
            </li>
        </ul>
        <hr>
        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-house"></i>
            <span><a class="nav-link active text" href="../pages/chat.php"><?= $lang['chat'] ?></a></span>
        </li>
        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-journal-check"></i>
            <span><a class="nav-link active text" href="../pages/mycourse.php"><?= $lang['mycourse'] ?></a></span>
        </li>
        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-file-person"></i>
            <span><a class="nav-link active text" href="../pages/results.php"><?= $lang['result'] ?></a></span>
        </li>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-patch-check"></i>
                <a class="nav-link text" href="../pages/certificate.php"><?= $lang['certificate'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-people"></i>
                <a class="nav-link text" href="../pages/user_management.php"><?= $lang['usermanagement'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-send"></i>
                <a class="nav-link text" href="../pages/email.php"><?= $lang['emailmanagement'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-book-half"></i>
                <a class="nav-link text" href="../pages/student_management.php"><?= $lang['studentmanagement'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-pen"></i>
                <a class="nav-link text" href="../pages/quiz_management.php"><?= $lang['quizmanagement'] ?></a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-universal-access"></i>
                <a class="nav-link text" href="../pages/access_management.php"><?= $lang['ams'] ?></a>
            </li>
            <li class="gap-2">
                <button class="btn btn-link nav-link text px-0" data-bs-toggle="collapse" data-bs-target="#systemSubNav" aria-expanded="false">
                    <i class="bi bi-gear"></i> <?= $lang['system'] ?>
                </button>
                <ul class="collapse nav flex-column " id="systemSubNav">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-square"></i>
                        <a class="nav-secondary text" href="../pages/infomation.php"><?= $lang['information'] ?></a>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-bug"></i>
                        <a class="nav-secondary text" href="../pages/log.php"><?= $lang['logs'] ?></a>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-database-fill-down"></i>
                        <a class="nav-secondary text" href="../pages/backup.php"><?= $lang['backup'] ?></a>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-database-fill-down"></i>
                        <a class="nav-secondary text" href="../pages/color.php"><?= $lang['color'] ?></a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>


        <div class="text-center mt-5"><?= $lang['chooselang'] ?></div>
        <!-- วางใน Navbar หรือเมนู -->
        <div class="d-flex justify-content-center p-2">
            <a href="<?= buildLangSwitchLink('th') ?>" class="btn btn-outline-secondary btn-sm <?= $langCode == 'th' ? 'active' : '' ?>">ไทย</a>
            <a href="<?= buildLangSwitchLink('en') ?>" class="btn btn-outline-secondary btn-sm <?= $langCode == 'en' ? 'active' : '' ?>">English</a>
        </div>
    </ul>
</div>