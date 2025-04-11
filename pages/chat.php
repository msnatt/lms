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
    <div class="main-inner">
        <div class="d-flex justify-content-center bg-light" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="mt-4 " style="width: 100%; max-width: 1650px;">
                <hr>
                <h2>Realtime Chat</h2>
                <div id="chatbox" style="height: 300px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom: 10px;"></div>
                <input type="text" id="msg" placeholder="Type a message..." style="width: 80%;">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-chat.html"; ?>
</body>

</html>