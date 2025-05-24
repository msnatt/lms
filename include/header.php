<header class="fw-medium">
    <div style="padding: 0rem ;">
        <nav class="navbar d-flex justify-content-center justify-content-lg-between navbar-expand-lg navbar-light bg-light">
            <div>
                <button id="sidebar_btn" class="btn ms-2"><i class="bi bi-list w-100 h-100"></i> </button>
                <a class="navbar-brand ms-2" href="../pages/home.php">
                    <img src="../assets/images/logo.png" alt="Logo" width="200">
                </a>
            </div>

            <div class="w-50 d-none d-lg-flex ">
                <div class=" ">
                    <!-- <div class="collapse navbar-collapse" id="navbarNav"> -->
                    <ul class="navbar-nav">
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
                </div>
            </div>
            <div class="w-25 d-flex align-items-center">

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/login.php"><?= $lang['login'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/register.php"><?= $lang['register'] ?></a>
                        </li>
                    </ul>
                <?php else: ?>
                    <img src="../assets/images/bg_cards/1.png" style="border-radius: 25px; height: 50px; width: 50px;">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link  text" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $lang['hi'] ?>! <?php echo $_SESSION['username'] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <!-- <li><a class="dropdown-item" href="../pages/setting.php">#Setting</a></li> -->
                                    <li><a class="dropdown-item" href="../pages/logout.php"><?= $lang['logout'] ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </div>

</header>