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
    <title><?= $lang['backup'] ?> - E-learning</title>
</head>

<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class=" d-flex bg-light bg-opacity-75">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <div class="container w-100">
                    <div class="d-flex align-items-center">
                        <button onclick="window.history.back();" class="btn col-2 col-lg-1 "><i class="bi bi-arrow-left fs-3"></i></button>
                        <h3><?= $lang['backup'] ?></h3>
                    </div>
                    <div class="px-4 py-2 d-flex justify-content-end gap-2">
                        <button class="btn btn-outline-secondary" style="width: 50%; max-width: 100px;" onclick="click_import()"><?= $lang['import'] ?></button>
                        <button class="btn btn-outline-secondary" style="width: 50%; max-width: 100px;" onclick="export_sql()"><?= $lang['export'] ?></button>
                    </div>
                    <!-- ซ่อน input file -->
                    <input type="file" id="sqlInput" class="d-none" accept=".sql" onchange="import_sql(event)">
                    <div id="status"></div>
                    <div class="d-flex w-100 border rounded border-secondary-subtle" style="min-height: 60vh;">
                        <div id="log_list" class="w-100 border-end border-secondary-subtle">
                            <div class="p-2">
                                <table id="table_backup">
                                    <thead>
                                        <tr class="text-center">
                                            <th> <?=$lang['time']?> </th>
                                            <th> <?=$lang['name']?>  </th>
                                            <th> <?=$lang['size']?>  </th>
                                            <th> <?=$lang['action']?> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="lang-data" type="application/json">
        <?= json_encode($lang, JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-backup.html"; ?>
</body>

</html>