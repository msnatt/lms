<style>
    /* ===== Sidebar nav — scoped to .sidebar, safe on every page (no Tailwind dependency) ===== */
    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .sidebar-section {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .sidebar-section:last-child {
        border-bottom: none;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.6rem 0.75rem;
        border: 0;
        border-radius: 0.6rem;
        background: transparent;
        color: #333;
        font-weight: 500;
        font-size: 0.95rem;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .sidebar-link i:first-child {
        width: 1.3rem;
        font-size: 1.1rem;
        text-align: center;
        flex-shrink: 0;
    }

    .sidebar-link:hover {
        background-color: rgba(2, 132, 199, 0.08);
        color: #0284c7 !important;
        transform: none !important;
    }

    .sidebar-link-sm {
        padding-left: 2rem;
        font-size: 0.85rem;
        font-weight: 400;
    }

    .sidebar-toggle .bi-chevron-down {
        margin-left: auto;
        font-size: 0.8rem;
        transition: transform 0.2s ease;
    }

    .sidebar-toggle[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(180deg);
    }

    .sidebar-user-btn {
        background: rgba(2, 132, 199, 0.08);
        color: #0284c7;
        font-weight: 600;
    }

    .sidebar-lang-label {
        font-size: 0.8rem;
        color: #888;
        text-align: center;
        margin-bottom: 0.4rem;
    }

    .sidebar-lang-switch {
        display: flex;
        gap: 0.2rem;
        padding: 0.2rem;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 999px;
    }

    .lang-pill {
        flex: 1;
        padding: 0.35rem 0;
        border-radius: 999px;
        text-align: center;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        transition: all 0.2s ease;
    }

    .lang-pill.active {
        background: #0284c7;
        color: #fff;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.35);
    }
</style>

<div class="sidebar collapsed" id="sidebar" style="background-color: <?= $bgside; ?>;">
    <nav class="sidebar-nav">

        <!-- Mobile User -->
        <div class="sidebar-section d-block d-lg-none">
            <button class="sidebar-link sidebar-toggle sidebar-user-btn" type="button"
                data-bs-toggle="collapse" data-bs-target="#mobileUserMenu">
                <i class="bi bi-person-circle"></i>
                <?= $lang['hi'] ?>! <?= $_SESSION['username'] ?? '' ?>
            </button>
            <div class="collapse" id="mobileUserMenu">
                <a class="sidebar-link sidebar-link-sm" href="../pages/logout.php">
                    <i class="bi bi-box-arrow-right"></i> <?= $lang['logout'] ?>
                </a>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="sidebar-section d-block d-lg-none">
            <a class="sidebar-link" href="../pages/home.php">
                <i class="bi bi-house"></i> <?= $lang['home'] ?>
            </a>
            <a class="sidebar-link" href="../pages/course.php">
                <i class="bi bi-journal-text"></i> <?= $lang['course'] ?>
            </a>
            <a class="sidebar-link" href="../pages/course_catalogue.php">
                <i class="bi bi-book-half"></i> <?= $lang['catalogue'] ?>
            </a>
            <a class="sidebar-link" href="../pages/contect.php">
                <i class="bi bi-envelope"></i> <?= $lang['contact'] ?>
            </a>
        </div>

        <!-- User Menu -->
        <div class="sidebar-section">
            <a class="sidebar-link" href="../pages/chat.php">
                <i class="bi bi-chat-dots"></i> <?= $lang['chat'] ?>
            </a>
            <a class="sidebar-link" href="../pages/mycourse.php">
                <i class="bi bi-journal-check"></i> <?= $lang['mycourse'] ?>
            </a>
            <a class="sidebar-link" href="../pages/results.php">
                <i class="bi bi-file-person"></i> <?= $lang['result'] ?>
            </a>
        </div>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>

            <!-- Admin -->
            <div class="sidebar-section">
                <a class="sidebar-link" href="../pages/certificate.php">
                    <i class="bi bi-patch-check"></i> <?= $lang['certificate'] ?>
                </a>
                <a class="sidebar-link" href="../pages/user_management.php">
                    <i class="bi bi-people"></i> <?= $lang['usermanagement'] ?>
                </a>
                <a class="sidebar-link" href="../pages/email.php">
                    <i class="bi bi-send"></i> <?= $lang['emailmanagement'] ?>
                </a>
                <a class="sidebar-link" href="../pages/student_management.php">
                    <i class="bi bi-book-half"></i> <?= $lang['studentmanagement'] ?>
                </a>
                <a class="sidebar-link" href="../pages/quiz_management.php">
                    <i class="bi bi-pen"></i> <?= $lang['quizmanagement'] ?>
                </a>
                <a class="sidebar-link" href="../pages/access_management.php">
                    <i class="bi bi-universal-access"></i> <?= $lang['ams'] ?>
                </a>

                <!-- System -->
                <button class="sidebar-link sidebar-toggle" type="button"
                    data-bs-toggle="collapse" data-bs-target="#systemMenu">
                    <i class="bi bi-gear"></i> <?= $lang['system'] ?>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse" id="systemMenu">
                    <a class="sidebar-link sidebar-link-sm" href="../pages/infomation.php">
                        <i class="bi bi-info-square"></i> <?= $lang['information'] ?>
                    </a>
                    <a class="sidebar-link sidebar-link-sm" href="../pages/log.php">
                        <i class="bi bi-bug"></i> <?= $lang['logs'] ?>
                    </a>
                    <a class="sidebar-link sidebar-link-sm" href="../pages/backup.php">
                        <i class="bi bi-database-fill-down"></i> <?= $lang['backup'] ?>
                    </a>
                    <a class="sidebar-link sidebar-link-sm" href="../pages/color.php">
                        <i class="bi bi-palette"></i> <?= $lang['color'] ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>

        <!-- Language -->
        <div class="sidebar-section">
            <div class="sidebar-lang-label"><?= $lang['chooselang'] ?></div>
            <div class="sidebar-lang-switch">
                <a href="<?= buildLangSwitchLink('th') ?>" class="lang-pill <?= $langCode == 'th' ? 'active' : '' ?>">ไทย</a>
                <a href="<?= buildLangSwitchLink('en') ?>" class="lang-pill <?= $langCode == 'en' ? 'active' : '' ?>">English</a>
            </div>
        </div>

    </nav>
</div>
