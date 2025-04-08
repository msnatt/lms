<?php
include '../components/session.php';
checkLogin();
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>



<body class="bg-custom">
    <?php include "../include/header.php"; ?>

    <div class="main-inner d-flex">
        <div class="bg-light d-flex" style="width: 100%;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="d-flex flex-column justify-content-center w-100">
                <h2 class="p-4" style="max-width: 100%">All Examination.</h2>
                <div class="px-4 d-flex justify-content-end gap-2 container">
                    <button class="btn btn-outline-secondary" style="width: 33%; max-width: 100px;" onclick="openExamCreate()">Create</button>
                </div>
                <div class="mt-3" style="min-height: 60vh;">
                    <table class="container border rounded bg-secondary bg-opacity-10" id="table_exam" >
                        <thead>
                            <tr>
                                <th> Title </th>
                                <th> Type </th>
                                <th> start time </th>
                                <th> Exam period </th>
                                <th> Create at </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-quiz-management.html"; ?>
</body>

</html>