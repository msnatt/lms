<?php $currentPage = basename($_SERVER['PHP_SELF'] ?? ''); ?>
<style>
    .site-header {
        position: relative;
        z-index: 1000;
        background: linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    .site-header .navbar {
        padding: .6rem 1.25rem;
    }

    .site-header .sidebar-toggle-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: .6rem;
        border: 0;
        background: transparent;
        font-size: 1.25rem;
        color: #fff;
        transition: background-color .2s ease;
    }

    .site-header .sidebar-toggle-btn:hover {
        background-color: rgba(255, 255, 255, .15);
    }

    .site-header .brand-logo {
        height: 40px;
        width: auto;
        filter: brightness(0) invert(1);
    }

    .site-header .main-nav {
        display: flex;
        align-items: center;
        gap: .25rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .site-header .main-nav li {
        margin: 0;
    }

    .site-header .main-nav a.nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        padding: .5rem .9rem;
        border-radius: .6rem;
        font-weight: 500 !important;
        color: rgba(255, 255, 255, .85) !important;
        text-decoration: none;
        transition: background-color .2s ease, color .2s ease;
    }

    .site-header .main-nav a.nav-link:hover {
        background-color: rgba(255, 255, 255, .1);
        color: #fff !important;
        transform: none !important;
    }

    .site-header .main-nav a.nav-link.active-link {
        color: #fff !important;
        font-weight: 600 !important;
    }

    .site-header .main-nav a.nav-link.active-link::after {
        content: "";
        position: absolute;
        left: .9rem;
        right: .9rem;
        bottom: .1rem;
        height: 3px;
        border-radius: 2px;
        background: #fff;
    }

    .site-header .guest-actions {
        display: flex;
        gap: .5rem;
        align-items: center;
    }

    .site-header .btn-ghost {
        padding: .5rem 1.1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .5);
        transition: all .2s ease;
    }

    .site-header .btn-ghost:hover {
        background-color: #fff;
        color: #0c4a6e;
    }

    .site-header .btn-solid {
        padding: .5rem 1.1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none;
        color: #0c4a6e;
        background: #fff;
        border: 1px solid #fff;
        transition: opacity .2s ease;
    }

    .site-header .btn-solid:hover {
        opacity: .9;
        color: #0c4a6e;
    }

    .site-header .navbar-nav > li {
        margin: 0;
    }

    .site-header .user-chip {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .3rem .8rem .3rem .3rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .15);
        text-decoration: none;
        color: #fff !important;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .site-header .user-chip:hover {
        background: rgba(255, 255, 255, .25);
    }

    .site-header .user-chip img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, .6);
    }

    .site-header .user-chip .chip-name {
        font-weight: 600;
        font-size: .9rem;
    }
</style>

<header class="site-header">
    <nav class="navbar d-flex justify-content-between navbar-expand-lg navbar-dark">
        <div class="d-flex align-items-center gap-2">
            <button id="sidebar_btn" class="sidebar-toggle-btn"><i class="bi bi-list"></i></button>
            <a class="navbar-brand d-flex align-items-center" href="../pages/home.php">
                <img src="../assets/images/logo.png" alt="Logo" class="brand-logo">
            </a>
        </div>

        <div class="d-none d-lg-flex">
            <ul class="main-nav">
                <li><a class="nav-link <?= $currentPage === 'home.php' ? 'active-link' : '' ?>" href="../pages/home.php"><?= $lang['home'] ?></a></li>
                <li><a class="nav-link <?= $currentPage === 'course.php' ? 'active-link' : '' ?>" href="../pages/course.php"><?= $lang['course'] ?></a></li>
                <li><a class="nav-link <?= $currentPage === 'course_catalogue.php' ? 'active-link' : '' ?>" href="../pages/course_catalogue.php"><?= $lang['catalogue'] ?></a></li>
                <li><a class="nav-link <?= $currentPage === 'contect.php' ? 'active-link' : '' ?>" href="../pages/contect.php"><?= $lang['contact'] ?></a></li>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="guest-actions">
                    <a class="btn-ghost" href="../pages/login.php"><?= $lang['login'] ?></a>
                    <a class="btn-solid" href="../pages/register.php"><?= $lang['register'] ?></a>
                </div>
            <?php else: ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="user-chip" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/images/bg_cards/1.png" alt="avatar">
                                <span class="chip-name"><?= $lang['hi'] ?>! <?php echo $_SESSION['username'] ?></span>
                                <i class="bi bi-chevron-down" style="font-size:.7rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../pages/logout.php"><i class="bi bi-box-arrow-right me-2"></i><?= $lang['logout'] ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>
