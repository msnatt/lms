<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>

<head>
    <title>CMS - E-learning</title>
</head>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4" style="max-width: 100%">CMS - Certificate Management System.</h2>
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="col-12 col-lg-7">
                        <div class="px-4 d-flex justify-content-center  gap-2 ">
                            <h5 class="col-3 col-lg-2">Template : </h5>
                            <select id="select-template" class="col-8 form-select w-50" required>
                                <option value="">=== Select Template ===</option>
                            </select>
                            <button class="btn btn-primary" style="width: 50%; max-width: 150px;" onclick="Export()">Export</button>
                        </div>
                        <div class="px-4 d-flex justify-content-center">
                            <div id="select-list" class="d-flex flex-wrap m-4 gap-2" style="width: 600px; min-height: 30px;"></div>
                        </div>
                        <div id="student_list" class="mt-3 d-flex flex-column align-items-center" style="min-height: 60vh;">
                            <table id="table_list_student" style="max-width: 800px;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px !important;"></th>
                                        <th>code</th>
                                        <th>name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex justify-content-center" style="border-left: 1px solid #ccc;">
                        <div class="w-100 " style="max-width: 500px;">
                            <h4>Pre-view Template</h4>
                            <img id="image-Show" src="../assets/images/default-template.png" class="mt-3" width="100%" style="max-width:100%; border: 2px solid #ccc;"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-certificate.html"; ?>
</body>

</html>