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
    <title><?=$lang['chat']?> - E-learning</title>
</head>


<body class="bg-custom">
    <?php include "../include/header.php"; ?>
    <div class="main-inner">
        <div class="d-flex justify-content-center bg-light" style="min-height: 70vh;">
            <?php include "../components/sidemenu.php"; ?>
            <div class="my-4 d-flex col-12 col-lg-10" style=" max-width: 1650px;">
                <div class="col-12 col-lg-2 border shadow-sm" id="box-list-room-chat" style="border-radius: 2rem 0 0 2rem;">
                    <div class="d-flex flex-wrap my-2 mx-4">
                        <div id="header-box" class="d-flex flex-wrap justify-content-between align-items-center w-100">
                            <div class="fs-4 fw-medium "><?=$lang['chat']?></div>
                            <button class="btn-newChat  bg-white rounded-circle fs-5" title="New Chat" onclick="createRoomChat()"><i class="bi bi-plus"></i></button>
                        </div>
                        <div class="bg-opacity-10 bg-white h-75" id="list-room-chat">

                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap " id="videocall-box" style="visibility: hidden;">
                    <!-- วิดีโอแชท -->
                    <div class="position-relative w-100">
                        <!-- remote video อยู่ด้านหลัง -->
                        <div id="remoteVideos" class="w-100 h-100" style="display: flex; gap: 10px;"></div>

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
                            <button id="btn-cam" class="btn btn-outline-light" title="Toggle Camera" onclick="toggleCam()">
                                <i class="bi bi-camera-video-fill"></i>
                            </button>

                            <!-- Toggle Mic -->
                            <button id="btn-mic" class="btn btn-outline-light" title="Toggle Mic" onclick="toggleMic()">
                                <i class="bi bi-mic-fill"></i>
                            </button>

                            <!-- Share Screen -->
                            <button id="btn-scrn-start" class="btn btn-outline-light" onclick="startScreenShare()" style="display: block;">
                                <i class="bi bi-display-fill"></i>
                            </button>
                            <button id="btn-scrn-stop" class="btn btn-danger" onclick="stopScreenShare()" style="display: none;">
                                <i class="bi bi-x-lg"></i>
                            </button>

                            <!-- Hang Up -->
                            <button class="btn btn-danger" title="Hang Up" onclick="toggleControl()">
                                <i class="bi bi-telephone-x-fill"></i>
                            </button>
                        </div>
                        <!-- setting -->
                        <div id="settingPanel" class="position-absolute translate-middle-x p-3 gap-1 bg-white rounded shadow flex-column"
                            style="display:flex; left: 50%; bottom: 20%; z-index: 11; width: 100%; max-width: 300px; height: 100%; max-height: 350px;">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 border rounded bg-light shadow-sm" id="commu-box" style="display: block;">
                    <div id="" class="bg-secondary-subtle bg-opacity-10 d-flex justify-content-between align-items-center px-3 py-1 " style="min-height: 50px;">
                        <div class="d-flex align-items-center">
                            <button class="d-lg-none d-block bg-transparent border-0" onclick="toggleChatRoom()"><i class="bi bi-list"></i></button>
                            <div id="chat-header" class="fw-bold fs-5 p-2" style="color:black;"></div>
                        </div>
                        <div class="gap-2" id="meet-box" style="display: none;">
                            <button id="btnVideoCall" class="btn " onclick="toggleControl() ">
                                <i class="bi bi-telephone-fill"></i>
                            </button>
                            <button id="btnVideoCall" class="btn " onclick="toggleControl() ">
                                <i class="bi bi-camera-video-fill"></i>
                            </button>
                        </div>
                    </div>

                    <!-- กล่องแชท -->
                    <div id="chat-box" class=" rounded-1 px-4 m-2" style="height: 75vh; max-height: 500px; overflow-y: scroll;">
                        <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                            <div class="text fs-3"><?=$lang['message']?></div>
                        </div>
                    </div>
                    <!-- input ส่งข้อความ -->
                    <div class="d-flex gap-1 my-2 mx-2">
                        <input class="form-control" type="text" id="chat-message" placeholder=<?=$lang['chatholder']?> />
                        <button class="btn btn-primary" onclick="sendMessage()"><i class="bi bi-send"></i></button>
                    </div>
                </div>
                <div id="infomation-box" class="col-lg-3 p-3 border bg-light shadow-sm d-none d-lg-block" style="border-radius:0 2rem 2rem 0;">
                    <div class="d-flex flex-column gap-2">
                        <h4 id="name-chat" class="mb-1"><?=$lang['unknown']?></h4>
                        <h6 class="text-muted mb-2"><?=$lang['member']?></h6>
                        <div id="status-chat" class="p-2 rounded bg-secondary bg-opacity-10 text-black">
                            -- <?=$lang['empty']?> --
                        </div>
                    </div>
                </div>
                <div style="position: fixed; bottom: 10%; right: 3%;">
                    <button id="btn-bot" class="botmenu" onclick="toggleChat()">
                        <i class="bi bi-robot px-1"></i>
                    </button>
                </div>

                <div id="chatBotBox" class="chat-bot-box" style="display: none;">
                    <div class="d-flex justify-content-between">
                        <div style="font-weight: 500; font-size: large; margin-bottom: 10px;"><?=$lang['bot']?></div>
                        <button class="border-0 bg-light" onclick="toggleChat()" onkeypress="if(event.key === 'Escape') toggleChat()"><i class="bi bi-x-lg px-1"></i></button>
                    </div>
                    <div id="chatMessages" style="height: 300px; overflow-y: auto; border: 1px solid #eee; padding: 5px; margin-bottom: 10px;">
                    </div>
                    <input class="form-control" type="text" id="chatInput" placeholder=<?=$lang['chatholder']?> style="width: 100%; padding: 5px;" onkeypress="if(event.key === 'Enter') sendMessageToBot()">
                </div>
            </div>
        </div>
    </div>


    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-chat.html"; ?>
</body>

</html>