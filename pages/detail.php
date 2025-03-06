<?php
include '../components/session.php';
$courseid = $_GET['courseid'] ?? 'N/A';
$user = $_SESSION['user'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../include/ref.html"; ?>
<?php include "../include/style.html"; ?>


<body class="bg-custom ">
    <?php include "../include/header.php"; ?>
    <br>
    <input type="hidden" value=<?php echo $user?>>
    <div class="main-inner">
        <div class="main-container bg-white bg-shadow" style="min-height: 70vh;" id="detail_div" name="detail_div"></div>
        <?php
        
        if ($user['rank'] == "admin"){
            echo `
            <div style="position: fixed; bottom: 10%; right: 3%;">
                <div class="bg-white" style="border-radius: 50%;">
                    <img src="../assets/images/add.png" width="50px" hight="50px" />
                </div>
            </div>
        `;
        }
        ?>
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-detail.html"; ?>

</body>

</html>