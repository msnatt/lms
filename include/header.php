<?php include "../include/ref.html"; ?>
<header>
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
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/course.php">Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/chat.php">Chat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/news.php">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/contect.php">Contact us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-15 d-none d-lg-flex align-items-center">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/register.php">Register</a>
                        </li>
                    </ul>
                <?php else: ?>
                    <img src="../assets/images/bg_cards/1.png" style="border-radius: 25px; height: 50px; width: 50px;">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link  text" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Hi! <?php echo $_SESSION['username'] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="../pages/mycourse.php">My Course</a></li>
                                    <li><a class="dropdown-item" href="../pages/setting.php">Setting</a></li>
                                    <li><a class="dropdown-item" href="../pages/logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="container-fluid d-flex d-lg-none">
                <!-- ปุ่ม Toggle -->
                <button class="navbar-toggler w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- เมนู Navbar -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link  text" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hi! <?php echo $_SESSION['username'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../pages/setting.php">Setting</a></li>
                                <li><a class="dropdown-item" href="../pages/logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text" href="../pages/home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/course.php">Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/news.php">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text" href="../pages/contect.php">Contact us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <hr style="margin: 0; border-color: #888; opacity: 100%;">

</header>