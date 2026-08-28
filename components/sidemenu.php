<div class="sidebar collapsed" id="sidebar"
    style="transition:width .3s ease,padding .3s ease; background-color:<?=$bgside;?>;">

    <ul class="navbar-nav">

        <!-- Mobile User -->
        <li class="d-block d-lg-none">
            <button class="btn btn-link nav-link text px-0"
                data-bs-toggle="collapse"
                data-bs-target="#mobileUserMenu">
                <i class="bi bi-person-circle"></i>
                <?= $lang['hi'] ?>! <?= $_SESSION['username'] ?? '' ?>
            </button>

            <ul class="collapse nav flex-column" id="mobileUserMenu">
                <li>
                    <a class="nav-secondary text" href="../pages/logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <?= $lang['logout'] ?>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Mobile Navigation -->
        <li class="d-block d-lg-none">
            <hr>

            <div class="sidebar-label"><?= $lang['home'] ?></div>
            <ul class="nav flex-column">

                <li>
                    <a class="nav-link text" href="../pages/home.php">
                        <i class="bi bi-house"></i>
                        <?= $lang['home'] ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link text" href="../pages/course.php">
                        <i class="bi bi-journal-text"></i>
                        <?= $lang['course'] ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link text" href="../pages/course_catalogue.php">
                        <i class="bi bi-book-half"></i>
                        <?= $lang['catalogue'] ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link text" href="../pages/contect.php">
                        <i class="bi bi-envelope"></i>
                        <?= $lang['contact'] ?>
                    </a>
                </li>

            </ul>
        </li>

        <hr class="d-block d-lg-none">

        <!-- User Menu -->
        <div class="sidebar-label"><?= $lang['mycourse'] ?></div>
        <li>
            <a class="nav-link text" href="../pages/chat.php">
                <i class="bi bi-chat-dots"></i>
                <?= $lang['chat'] ?>
            </a>
        </li>

        <li>
            <a class="nav-link text" href="../pages/mycourse.php">
                <i class="bi bi-journal-check"></i>
                <?= $lang['mycourse'] ?>
            </a>
        </li>

        <li>
            <a class="nav-link text" href="../pages/results.php">
                <i class="bi bi-file-person"></i>
                <?= $lang['result'] ?>
            </a>
        </li>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>

            <hr>

            <!-- Admin -->
            <div class="sidebar-label"><?= $lang['usermanagement'] ?></div>

            <li>
                <a class="nav-link text" href="../pages/certificate.php">
                    <i class="bi bi-patch-check"></i>
                    <?= $lang['certificate'] ?>
                </a>
            </li>

            <li>
                <a class="nav-link text" href="../pages/user_management.php">
                    <i class="bi bi-people"></i>
                    <?= $lang['usermanagement'] ?>
                </a>
            </li>

            <li>
                <a class="nav-link text" href="../pages/email.php">
                    <i class="bi bi-send"></i>
                    <?= $lang['emailmanagement'] ?>
                </a>
            </li>

            <li>
                <a class="nav-link text" href="../pages/student_management.php">
                    <i class="bi bi-book-half"></i>
                    <?= $lang['studentmanagement'] ?>
                </a>
            </li>

            <li>
                <a class="nav-link text" href="../pages/quiz_management.php">
                    <i class="bi bi-pen"></i>
                    <?= $lang['quizmanagement'] ?>
                </a>
            </li>

            <li>
                <a class="nav-link text" href="../pages/access_management.php">
                    <i class="bi bi-universal-access"></i>
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
                    <i class="bi bi-chevron-down small ms-auto text-muted"></i>

                </button>

                <ul class="collapse nav flex-column ms-3" id="systemMenu">

                    <li>
                        <a class="nav-secondary text" href="../pages/infomation.php">
                            <i class="bi bi-info-square"></i>
                            <?= $lang['information'] ?>
                        </a>
                    </li>

                    <li>
                        <a class="nav-secondary text" href="../pages/log.php">
                            <i class="bi bi-bug"></i>
                            <?= $lang['logs'] ?>
                        </a>
                    </li>

                    <li>
                        <a class="nav-secondary text" href="../pages/backup.php">
                            <i class="bi bi-database-fill-down"></i>
                            <?= $lang['backup'] ?>
                        </a>
                    </li>

                    <li>
                        <a class="nav-secondary text" href="../pages/color.php">
                            <i class="bi bi-palette"></i>
                            <?= $lang['color'] ?>
                        </a>
                    </li>

                </ul>

            </li>

        <?php endif; ?>

        <hr>

        <!-- Language -->
        <li class="text-center mt-2">
            <span class="sidebar-label d-inline-block"><?= $lang['chooselang'] ?></span>
        </li>

        <li class="d-flex justify-content-center gap-2 p-2">
            <a href="<?= buildLangSwitchLink('th') ?>"
                class="btn btn-outline-primary btn-sm rounded-pill <?= $langCode == 'th' ? 'active' : '' ?>">
                ไทย
            </a>

            <a href="<?= buildLangSwitchLink('en') ?>"
                class="btn btn-outline-primary btn-sm rounded-pill <?= $langCode == 'en' ? 'active' : '' ?>">
                English
            </a>
        </li>

    </ul>

</div>
