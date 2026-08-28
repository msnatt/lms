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
    <title><?= $lang['chat'] ?> - E-learning</title>
</head>

<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="chat-page-wrap">

                <div class="page-title">
                    <span class="page-title-icon"><i class="bi bi-chat-dots"></i></span>
                    <h2><?= $lang['chat'] ?></h2>
                </div>

                <div class="chat-shell">
                    <div class="col-12 col-lg-2 chat-sidebar" id="box-list-room-chat">
                        <div class="chat-sidebar-inner">
                            <div class="chat-sidebar-header" id="header-box">
                                <div class="chat-sidebar-title"><?= $lang['chat'] ?></div>
                                <button class="btn-newChat icon-btn" title="New Chat" onclick="createRoomChat()"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="chat-room-list" id="list-room-chat">
                                <div class="dash-skeleton px-3 py-2">
                                    <div class="dash-skeleton-line" style="width:80%"></div>
                                    <div class="dash-skeleton-line" style="width:40%"></div>
                                </div>
                                <div class="dash-skeleton px-3 py-2">
                                    <div class="dash-skeleton-line" style="width:75%"></div>
                                    <div class="dash-skeleton-line" style="width:30%"></div>
                                </div>
                            </div>
                        </div>
                        <!-- STATUS -->
                        <div id="wsStatus" class="chat-ws-status">
                            <div id="wsBody" class="chat-ws-body">
                                <!-- Spinner -->
                                <div id="wsSpinner" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                <!-- Text -->
                                <span id="wsText" class="text-muted">Connecting...</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap chat-videocall" id="videocall-box" style="visibility: hidden;">
                        <!-- วิดีโอแชท -->
                        <div class="position-relative w-100 h-100">
                            <!-- remote video อยู่ด้านหลัง -->
                            <div id="remoteVideos" class="video-container"></div>

                            <!-- local video ลอยบนมุมขวาล่าง -->
                            <video id="localVideo" autoplay muted class="chat-local-video"></video>

                            <!-- control panel -->
                            <div class="chat-call-controls">
                                <!-- Setting Icon -->
                                <button class="btn btn-outline-light chat-call-btn" title="Settings" onclick="toggleSettingPanel()">
                                    <i class="bi bi-gear-fill"></i>
                                </button>

                                <!-- Toggle Camera -->
                                <button id="btn-cam" class="btn btn-outline-light chat-call-btn" title="Toggle Camera" onclick="toggleCam()">
                                    <i class="bi bi-camera-video-fill"></i>
                                </button>

                                <!-- Toggle Mic -->
                                <button id="btn-mic" class="btn btn-outline-light chat-call-btn" title="Toggle Mic" onclick="toggleMic()">
                                    <i class="bi bi-mic-fill"></i>
                                </button>

                                <!-- Share Screen -->
                                <button id="btn-scrn-start" class="btn btn-outline-light chat-call-btn" onclick="startScreenShare()" style="display: block;">
                                    <i class="bi bi-display-fill"></i>
                                </button>
                                <button id="btn-scrn-stop" class="btn btn-danger chat-call-btn" onclick="stopScreenShare()" style="display: none;">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                                <!-- Hang Up -->
                                <button class="btn btn-danger chat-call-btn" title="Hang Up" onclick="toggleControl()">
                                    <i class="bi bi-telephone-x-fill"></i>
                                </button>
                            </div>
                            <!-- setting -->
                            <div id="settingPanel" class="chat-setting-panel" style="display:flex;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 chat-main" id="commu-box" style="display: block;">
                        <div class="chat-main-inner">
                            <div class="chat-topbar">
                                <div class="d-flex align-items-center gap-2">
                                    <button class="d-lg-none icon-btn" onclick="toggleChatRoom()"><i class="bi bi-list"></i></button>
                                    <div id="chat-header" class="chat-title"></div>
                                </div>
                                <div class="chat-meet-box gap-2" id="meet-box" style="display: none;">
                                    <button id="btnVideoCall" class="icon-btn" onclick="toggleControl()">
                                        <i class="bi bi-telephone-fill"></i>
                                    </button>
                                    <button id="btnVideoCall" class="icon-btn" onclick="toggleControl()">
                                        <i class="bi bi-camera-video-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- กล่องแชท -->
                            <div id="chat-box" class="chat-messages">
                                <div class="chat-empty-state">
                                    <i class="bi bi-chat-square-heart"></i>
                                    <div><?= $lang['message'] ?></div>
                                </div>
                            </div>
                            <!-- input ส่งข้อความ -->
                            <div class="chat-composer">
                                <input class="form-control" type="text" id="chat-message" placeholder="<?= $lang['chatholder'] ?>" />
                                <button class="btn btn-primary chat-send-btn" onclick="sendMessage()"><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </div>

                    <div id="infomation-box" class="col-lg-3 chat-info-panel">
                        <div class="chat-info-inner">
                            <div id="name-chat" class="chat-info-name"><?= $lang['unknown'] ?></div>
                            <h6 class="chat-info-subtitle"><?= $lang['member'] ?></h6>
                            <div id="status-chat" class="chat-member-list">
                                -- <?= $lang['empty'] ?> --
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <button id="btn-bot" class="botmenu chat-bot-fab" onclick="toggleChat()">
        <i class="bi bi-robot px-1"></i>
    </button>

    <div id="chatBotBox" class="chat-bot-box" style="display: none;">
        <div class="chat-bot-header">
            <div class="chat-bot-title"><i class="bi bi-robot"></i><?= $lang['bot'] ?></div>
            <button class="chat-bot-close" onclick="toggleChat()" onkeypress="if(event.key === 'Escape') toggleChat()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div id="chatMessages" class="chat-bot-messages">
        </div>
        <input class="form-control" type="text" id="chatInput" placeholder="<?= $lang['chatholder'] ?>" onkeypress="if(event.key === 'Enter') sendMessageToBot()">
    </div>

    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>
    <?php include "../include/scriptjs-chat.html"; ?>
</body>

</html>
