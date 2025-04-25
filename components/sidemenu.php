<div class="sidebar" id="sidebar" style="border-right: 1px solid #aaa;">
    <ul class="navbar-nav">
        <li class="d-flex align-items-center gap-2">
            <i class="bi bi-house"></i>
            <span><a class="nav-link active text" href="../pages/chat.php">General Chat</a></span>
        </li>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-book-half"></i>
                <a class="nav-link text" href="../pages/student_management.php">Student management</a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-chat-left-dots"></i>
                <a class="nav-link text" href="../pages/user_management.php">User Management</a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-chat-left-dots"></i>
                <a class="nav-link text" href="../pages/quiz_management.php">Quiz Management</a>
            </li>
            <li class="d-flex align-items-center gap-2">
                <i class="bi bi-chat-left-dots"></i>
                <a class="nav-link text" href="../pages/certificate.php">Certificate</a>
            </li>
            <li class="gap-2">
                <button class="btn btn-link nav-link text px-0" data-bs-toggle="collapse" data-bs-target="#systemSubNav" aria-expanded="false">
                    <i class="bi bi-gear"></i> System
                </button>
                <ul class="collapse nav flex-column " id="systemSubNav">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-square"></i>
                        <a class="nav-secondary text" href="../pages/infomation.php">#infomation.</a>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-bug"></i>
                        <a class="nav-secondary text" href="../pages/log.php">Log</a>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-database-fill-down"></i>
                        <a class="nav-secondary text" href="../pages/backup.php">backup data</a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</div>