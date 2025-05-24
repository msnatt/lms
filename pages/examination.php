<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <meta charset="UTF-8">
    <title><?= $lang['exam'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <!-- <div class="">
            <h3 class="p-4">FT - LMS</h3>
        </div> -->
        <div class="" style="min-height: 70vh;">

            <div id="exam-container" class="container py-2 px-4 justify-content-center">
                <h1 id="exam-title"></h1>
                <p id="exam-description" class="text-muted"></p>
                <p id="exam-time" class="text-muted"></p>
                <button id="startExamBtn" class="btn btn-primary" onclick="startExam()"><?= $lang['start'] ?></button>
            </div>
            <div id="toggle-form" class="bg-white bg-opacity-75 container d-none py-4 px-5">
                <form method="POST" onsubmit="handleSubmit(event)" class="w-100 d-flex flex-column">
                    <div id="questions-list"></div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3" style="width: 100%; max-width: 200px;"><?= $lang['sendexam'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-examination.html"; ?>
</body>

</html>