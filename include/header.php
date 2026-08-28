<header class="app-topbar fw-medium">
    <nav class="navbar d-flex justify-content-between navbar-expand-lg navbar-light px-3 py-2" style="background-color: <?=$bgbar;?>;">
        <div class="d-flex align-items-center gap-2">
            <button id="sidebar_btn" class="topbar-toggle"><i class="bi bi-list"></i></button>
            <a class="navbar-brand ms-1 d-flex align-items-center" href="../pages/home.php">
                <img src="../assets/images/logo.png" alt="Logo">
            </a>
        </div>

        <div class="d-none d-lg-flex">
            <ul class="navbar-nav topbar-nav flex-row gap-1">
                <li>
                    <a class="nav-link text" href="../pages/home.php"><?= $lang['home'] ?></a>
                </li>
                <li>
                    <a class="nav-link text" href="../pages/course.php"><?= $lang['course'] ?></a>
                </li>
                <li>
                    <a class="nav-link text" href="../pages/course_catalogue.php"><?= $lang['catalogue'] ?></a>
                </li>
                <li>
                    <a class="nav-link text" href="../pages/contect.php"><?= $lang['contact'] ?></a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav flex-row gap-2">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary btn-sm" href="../pages/login.php"><?= $lang['login'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="../pages/register.php"><?= $lang['register'] ?></a>
                    </li>
                </ul>
            <?php else: ?>
                <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="topbar-user-btn" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="topbar-avatar" src="../assets/images/bg_cards/1.png" alt="avatar">
                                <span class="text d-none d-sm-inline"><?= $lang['hi'] ?>! <?php echo $_SESSION['username'] ?></span>
                                <i class="bi bi-chevron-down small text-muted"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../pages/logout.php"><i class="bi bi-box-arrow-right me-2"></i><?= $lang['logout'] ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>