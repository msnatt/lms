<?php
include '../components/session.php';
?>

<!DOCTYPE html>
<html lang="<?= $langCode ?>">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title><?= $lang['color'] ?> - E-learning</title>
    
</head>


<body style="background-color: <?= $bg; ?>; color: <?= $text; ?>;">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="mt-4 flex-grow-1" style="transition: all 0.3s ease;">
            <h2 class="mb-3">🎨 แก้ไขสีธีม</h2>
            <div class="d-flex container">
                <form method="post" class="w-50 mb-4">
                    <div class=" gap-4 mb-3">
                        <label for="bg" class="form-label">เลือกสี BG:</label>
                        <input type="color" id="bg" name="bg" class="form-control form-control-color w-25"
                            value="<?= $bg ?>" title="เลือกสี">
                        <label for="bg-side" class="form-label">เลือกสี BG side:</label>
                        <input type="color" id="bgside" name="bgside" class="form-control form-control-color w-25"
                            value="<?= $bgside ?>" title="เลือกสี">
                        <label for="text" class="form-label">เลือกสี text:</label>
                        <input type="color" id="text" name="text" class="form-control form-control-color w-25"
                            value="<?= $text ?>" title="เลือกสี">
                        <label for="button" class="form-label">เลือกสี button:</label>
                        <input type="color" id="button" name="button" class="form-control form-control-color w-25"
                            value="<?= $button ?>" title="เลือกสี">
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
            <br>
            <br>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-home.html"; ?>



</body>


</html>