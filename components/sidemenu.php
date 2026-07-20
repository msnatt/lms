<div class="sidebar collapsed" id="sidebar"
    style="border-right:1px solid #aaa; transition:width .3s ease,padding .3s ease; background-color:<?=$bgside;?>;">

    <ul class="navbar-nav">

        <!-- Mobile User -->
        <li class="d-block d-lg-none">
            <button class="btn btn-link nav-link text px-0"
                data-bs-toggle="collapse"
                data-bs-target="#mobileUserMenu">
                <?= $lang['hi'] ?>! <?= $_SESSION['username'] ?? '' ?>
            </button>

            <ul class="collapse nav flex-column ms-3" id="mobileUserMenu">
                <li class="d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <a class="nav-secondary text" href="../pages/logout.php">
                        <?= $lang['logout'] ?>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Mobile Navigation -->
        <li class="d-block d-lg-none">
            <hr>

            <ul class="nav flex-column">

                <li class="d-flex align-items-center gap-2">
                    <a class="nav-link text" href="../pages/home.php">
                        <?= $lang['home'] ?>
                    </a>
                </li>

                <li class="d-flex align-items-center gap-2">
                    <a class="nav-link text" href="../pages/course.php">
                        <?= $lang['course'] ?>
                    </a>
                </li>

                <li class="d-flex align-items-center gap-2">
                    <a class="nav-link text" href="../pages/course_catalogue.php">
                        <?= $lang['catalogue'] ?>
                    </a>
                </li>

                <li class="d-flex align-items-center gap-2">
                    <a class="nav-link text" href="../pages/contect.php">
                        <?= $lang['contact'] ?>
                    </a>
                </li>

            </ul>
        </li>

        <hr>

        <!-- User Menu -->
        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-house"></i>
            <a class="nav-link active text" href="../pages/chat.php">
                <?= $lang['chat'] ?>
            </a>
        </li>

        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-journal-check"></i>
            <a class="nav-link active text" href="../pages/mycourse.php">
                <?= $lang['mycourse'] ?>
            </a>
        </li>

        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-file-person"></i>
            <a class="nav-link active text" href="../pages/results.php">
                <?= $lang['result'] ?>
            </a>
        </li>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>

            <hr>

            <!-- Admin -->
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-patch-check"></i>
                <a class="nav-link text" href="../pages/certificate.php">
                    <?= $lang['certificate'] ?>
                </a>
            </li>

            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-people"></i>
                <a class="nav-link text" href="../pages/user_management.php">
                    <?= $lang['usermanagement'] ?>
                </a>
            </li>

            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-send"></i>
                <a class="nav-link text" href="../pages/email.php">
                    <?= $lang['emailmanagement'] ?>
                </a>
            </li>

            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-book-half"></i>
                <a class="nav-link text" href="../pages/student_management.php">
                    <?= $lang['studentmanagement'] ?>
                </a>
            </li>

            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-pen"></i>
                <a class="nav-link text" href="../pages/quiz_management.php">
                    <?= $lang['quizmanagement'] ?>
                </a>
            </li>

            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-universal-access"></i>
                <a class="nav-link text" href="../pages/access_management.php">
                    <?= $lang['ams'] ?>
                </a>
            </li>

            <!-- System -->
            <li>

                <button class="btn btn-link nav-link text px-0"
                    data-bs-toggle="collapse"
                    data-bs-target="#systemMenu">

                    <i class="bi bi-gear"></i>
                    <?= $lang['system'] ?>

                </button>

                <ul class="collapse nav flex-column ms-3" id="systemMenu">

                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-square"></i>
                        <a class="nav-secondary text" href="../pages/infomation.php">
                            <?= $lang['information'] ?>
                        </a>
                    </li>

                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-bug"></i>
                        <a class="nav-secondary text" href="../pages/log.php">
                            <?= $lang['logs'] ?>
                        </a>
                    </li>

                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-database-fill-down"></i>
                        <a class="nav-secondary text" href="../pages/backup.php">
                            <?= $lang['backup'] ?>
                        </a>
                    </li>

                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-palette"></i>
                        <a class="nav-secondary text" href="../pages/color.php">
                            <?= $lang['color'] ?>
                        </a>
                    </li>

                </ul>

            </li>

        <?php endif; ?>

        <hr>

        <!-- Language -->
        <li class="text-center mt-3">
            <?= $lang['chooselang'] ?>
        </li>

        <li class="d-flex justify-content-center gap-2 p-2">
            <a href="<?= buildLangSwitchLink('th') ?>"
                class="btn btn-outline-secondary btn-sm <?= $langCode == 'th' ? 'active' : '' ?>">
                ไทย
            </a>

            <a href="<?= buildLangSwitchLink('en') ?>"
                class="btn btn-outline-secondary btn-sm <?= $langCode == 'en' ? 'active' : '' ?>">
                English
            </a>
        </li>

    </ul>

</div>