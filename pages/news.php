<?php
include '../components/session.php';
checkLogin();
?>


<!DOCTYPE html>
<html lang="en">

<?php session_start(); ?>
<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <div class="container  bg-light">
        <div class=" py-5">
            <!-- Section Header -->
            <div class="text-center mb-4">
                <h2 class="text-warning"><i class="bi bi-newspaper"></i> Latest <span class="text-dark">News</span></h2>
            </div>

            <!-- News Content -->
            <div id="news-content" class="row g-4">
                <!-- ข่าวหน้าแรก -->
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-news.html"; ?>
</body>

</html>