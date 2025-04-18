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
            <div class="mt-4 d-flex gap-2" style="width: 100%; max-width: 1650px;">
                <div class="col-12 col-lg-2 border rounded bg-light shadow-sm d-none d-lg-block" id="box-list-room-chat">
                    <div class="bg-opacity-10 bg-white h-75" id="list-room-chat">
                        <div class="d-flex justify-content-between align-items-center my-2 mx-3">
                            <h5 class="mb-0">Chats</h5>
                            <button class="btn-newChat rounded-circle fs-5" title="New Chat"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap " id="videocall-box" style="display: none;">
                    <video id="localVideo" autoplay muted class="w-100 rounded shadow-sm"></video>
                    <video id="remoteVideo" autoplay class="w-100 rounded shadow-sm"></video>
                </div>
                <div class="col-12 col-lg-8 border rounded bg-light shadow-sm" id="commu-box" style="display: block;">
                    <div id="" class="d-flex justify-content-between align-items-center px-3 py-1 bg-light" style="min-height: 50px;">
                        <div id="chat-header" class="fw-bold fs-5 p-2"></div>

                        <div class="gap-2" id="meet-box" style="display: none;">
                            <button id="btnVideoCall" class="btn btn-success" onclick="toggleControl() ">
                                <i class="bi bi-camera-video"></i> Video Call
                            </button>
                            <button id="btnShareScreen" class="btn btn-primary">
                                <i class="bi bi-display"></i> Share Screen
                            </button>
                        </div>
                    </div>

                    <!-- กล่องแชท -->
                    <div id="chat-box" class="bg-opacity-10 bg-secondary rounded-1 px-4 m-2" style="height: 75%; max-height: 500px; overflow-y: scroll;">
                        <div class="d-flex justify-content-center align-items-center w-100 h-100">
                            <p>-- Select Chat or New Chat! --</p>
                        </div>
                    </div>
                    <!-- input ส่งข้อความ -->
                    <div class="d-flex gap-1 my-2 mx-2">
                        <input class="form-control" type="text" id="chat-message" placeholder="พิมพ์ข้อความ..." />
                        <button class="btn btn-primary" onclick="sendMessage()">Send</button>
                    </div>
                </div>
                <div id="infomation-box" class="col-lg-2 p-3 border rounded bg-light shadow-sm" style="display: block;">
                    <div class="d-flex flex-column gap-2">
                        <h4 id="name-chat" class="mb-1">Unknown</h4>
                        <h6 class="text-muted mb-2">Member</h6>
                        <div id="status-chat" class="p-2 rounded bg-secondary text-white">
                            -- Empty --
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-chat.html"; ?>
</body>

</html>