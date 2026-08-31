<?php
include '../components/session.php';

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>


<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>
<head>
    <meta charset="UTF-8">
    <title><?= $lang['login'] ?> - E-learning</title>

    <!-- Tailwind (scoped to login.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
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
        /* หน้า login ไม่มี sidemenu ปุ่ม hamburger จึงไม่มีอะไรให้เปิด */
        #sidebar_btn { display: none; }
        /* input:focus ของ style.html ยังเป็นขอบส้มเดิม (ใช้ร่วมทั้งระบบ) ทับด้วยสีฟ้าของแบรนด์ใหม่เฉพาะหน้านี้ */
        .login-card .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25);
        }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="tw-flex tw-min-h-[90vh]">

        <!-- แผงแบรนด์ (ซ่อนบนจอเล็ก) -->
        <div class="tw-hidden lg:tw-flex lg:tw-w-1/2 tw-bg-gradient-to-br tw-from-brand tw-to-brandink tw-text-white tw-flex-col tw-justify-center tw-p-12">
            <img src="../assets/images/logo.png" alt="Logo" class="tw-w-40 tw-mb-8 tw-brightness-0 tw-invert">
            <h1 class="tw-text-3xl tw-font-bold tw-mb-3"><?= $lang['home_hero_title'] ?></h1>
            <p class="tw-text-lg tw-opacity-90"><?= $lang['home_hero_sub'] ?></p>
        </div>

        <!-- ฟอร์มล็อกอิน -->
        <div class="tw-w-full lg:tw-w-1/2 tw-flex tw-items-center tw-justify-center tw-p-6">
            <div class="login-card tw-w-full tw-max-w-md tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-8">
                <h2 class="tw-text-center tw-text-2xl tw-font-bold tw-mb-6"><?= $lang['login'] ?></h2>

                <?php if (!empty($error)): ?>
                    <div class="tw-flex tw-items-center tw-gap-2 tw-bg-red-50 tw-text-red-600 tw-rounded-lg tw-px-4 tw-py-3 tw-mb-4 tw-text-sm">
                        <i class="bi bi-exclamation-circle"></i>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <form action="../config/db_login.php" method="post">
                    <div class="tw-mb-3">
                        <label class="form-label fw-medium"><?= $lang['username'] ?></label>
                        <input class="form-control rounded" type="text" name="username" required placeholder="<?= $lang['husername'] ?>">
                    </div>
                    <div class="tw-mb-4">
                        <label class="form-label fw-medium"><?= $lang['password'] ?></label>
                        <div class="tw-relative">
                            <input id="password_field" class="form-control rounded" type="password" name="password" required placeholder="<?= $lang['hpassword'] ?>">
                            <button type="button" id="toggle_password" aria-label="<?= $lang['showpassword'] ?>" class="tw-absolute tw-right-3 tw-top-1/2 tw--translate-y-1/2 tw-border-0 tw-bg-transparent tw-text-slate-500">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button class="tw-w-full tw-bg-brand tw-text-white tw-rounded-lg tw-py-2 tw-font-medium tw-border-0 hover:tw-opacity-90" type="submit"><?= $lang['login'] ?></button>
                </form>
            </div>
        </div>

    </div>
    <?php include "../include/scriptjs.html"; ?>
    <script>
        document.getElementById('toggle_password').addEventListener('click', function () {
            const field = document.getElementById('password_field');
            const icon = this.querySelector('i');
            const isHidden = field.type === 'password';
            field.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
        });
    </script>
</body>

</html>
