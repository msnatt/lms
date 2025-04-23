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
                <div class="d-flex flex-wrap " id="videocall-box" style="visibility: hidden;">
                    <!-- วิดีโอแชท -->
                    <div class="position-relative" style="height: 500px;">
                        <!-- remote video อยู่ด้านหลัง -->
                        <video id="remoteVideo" autoplay class="w-100 h-100 object-fit-cover rounded"></video>

                        <!-- local video ลอยบนมุมขวาล่าง -->
                        <video id="localVideo" autoplay muted
                            class="position-absolute rounded shadow border border-white"
                            style="width: 200px; bottom: 100px; right: 20px; z-index: 10;"></video>

                        <!-- control panel -->
                        <div class="position-absolute bottom-0 start-50 translate-middle-x p-3 d-flex gap-3 bg-dark bg-opacity-50 rounded shadow"
                            style="z-index: 11;">
                            <!-- Setting Icon -->
                            <button class="btn btn-outline-light" title="Settings" onclick="toggleSettingPanel()">
                                <i class="bi bi-gear-fill"></i>
                            </button>

                            <!-- Toggle Camera -->
                            <button class="btn btn-outline-light" title="Toggle Camera" onclick="toggleCamera()">
                                <i class="bi bi-camera-video-fill"></i>
                            </button>

                            <!-- Toggle Mic -->
                            <button class="btn btn-outline-light" title="Toggle Mic" onclick="toggleMic()">
                                <i class="bi bi-mic-fill"></i>
                            </button>

                            <!-- Share Screen -->
                            <button class="btn btn-outline-light" title="Share Screen" onclick="shareScreen()">
                                <i class="bi bi-display-fill"></i>
                            </button>

                            <!-- Hang Up -->
                            <button class="btn btn-danger" title="Hang Up" onclick="toggleControl()">
                                <i class="bi bi-telephone-x-fill"></i>
                            </button>
                        </div>
                        <!-- setting -->
                        <div id="settingPanel" class="position-absolute translate-middle-x p-3 gap-3 bg-white rounded shadow flex-column"
                            style="display:flex; left: 50%; bottom: 20%; z-index: 11; width: 100%; max-width: 300px; height: 100%; max-height: 300px;">
                            <div class="d-flex justify-content-between">
                                <div class="fs-4">Settings</div>
                                <button style="border: 0; background-color: #ffffff00;" onclick="toggleSettingPanel()">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="fs-6">Camera</div>
                            <select id="cam-select"></select>
                            <div class="fs-6">Audio</div>
                            <select id="mic-select"></select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 border rounded bg-light shadow-sm" id="commu-box" style="display: block;">
                    <div id="" class="d-flex justify-content-between align-items-center px-3 py-1 bg-light" style="min-height: 50px;">
                        <div id="chat-header" class="fw-bold fs-5 p-2"></div>

                        <div class="gap-2" id="meet-box" style="display: none;">
                            <button id="btnVideoCall" class="btn btn-success" onclick="toggleControl() ">
                                <i class="bi bi-camera-video"></i> Video Call
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