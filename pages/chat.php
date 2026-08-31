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

    <!-- Tailwind (scoped to chat.php only: prefix + preflight off so it never touches Bootstrap-based partials) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        brand: '#0284c7',
                        brandink: '#0c4a6e'
                    }
                }
            }
        }
    </script>
    <style>
        /* จัดความกว้าง/สูงของ 4 แผงแชทด้วย flexbox ล้วน แทนเปอร์เซ็นต์ของ Bootstrap grid
           (ผสมกับ tw-gap แล้ว % เดิมจะเกิน 100% ทำให้ infomation-box ตกบรรทัดใหม่)
           ยังคง class ชื่อเดิม col-lg-7 / col-lg-3 / col-7 ไว้ เพราะ scriptjs-chat.html
           toggle ชื่อ class พวกนี้อยู่ตรงๆ (togglewidthVideoandChats) */
        @media (min-width: 992px) {
            #commu-box.col-lg-7 { flex: 1 1 0%; }
            #commu-box.col-lg-3 { flex: 0 0 340px; }
        }
        #videocall-box { flex: 0 0 0; min-width: 0; }
        #videocall-box.col-7 { flex: 1 1 0%; }
    </style>
</head>

<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="tw-flex tw-flex-col lg:tw-flex-row lg:tw-flex-nowrap tw-items-stretch tw-gap-4 tw-p-4 tw-overflow-y-auto" style="height: calc(100vh - 96px);">

                <!-- รายการห้องแชท -->
                <div class="tw-w-full lg:tw-w-64 lg:tw-shrink-0 tw-bg-white tw-rounded-2xl tw-shadow tw-overflow-hidden tw-flex tw-flex-col tw-relative tw-min-h-0" id="box-list-room-chat">
                    <div id="header-box" class="tw-flex tw-flex-wrap tw-justify-between tw-items-center tw-w-full tw-px-4 tw-py-3 tw-border-b tw-border-slate-100">
                        <div class="tw-flex tw-items-center tw-gap-2">
                            <i class="bi bi-chat-dots-fill tw-text-brand tw-text-xl"></i>
                            <span class="tw-font-bold tw-text-lg"><?= $lang['chat'] ?></span>
                        </div>
                        <button class="btn-newChat tw-w-9 tw-h-9 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 tw-flex tw-items-center tw-justify-center hover:tw-opacity-90" title="New Chat" onclick="createRoomChat()"><i class="bi bi-plus tw-text-xl"></i></button>
                    </div>
                    <div class="tw-flex tw-flex-col tw-overflow-y-auto tw-flex-1 tw-min-h-0" id="list-room-chat">
                        <div class="dash-skeleton px-3">
                            <div class="dash-skeleton-line" style="width:80%"></div>
                            <div class="dash-skeleton-line" style="width:40%"></div>
                        </div>
                        <div class="dash-skeleton px-3">
                            <div class="dash-skeleton-line" style="width:75%"></div>
                            <div class="dash-skeleton-line" style="width:30%"></div>
                        </div>
                    </div>
                    <!-- STATUS -->
                    <div id="wsStatus" class="tw-absolute tw-top-3 tw-right-3">
                        <div id="wsBody" class="d-flex align-items-center gap-2 tw-px-3 tw-py-1 tw-rounded-full shadow-sm" style="background-color: #CFCFCF;">
                            <div id="wsSpinner" class="spinner-border spinner-border-sm text-primary" role="status" style="width:.8rem;height:.8rem;"></div>
                            <span id="wsText" class="text-muted tw-text-xs">Connecting...</span>
                        </div>
                    </div>
                </div>

                <!-- วิดีโอคอล -->
                <div class="d-flex flex-wrap tw-rounded-2xl tw-overflow-hidden tw-relative" id="videocall-box" style="visibility: hidden; background:#111;">
                    <div class="position-relative w-100 h-100">
                        <div id="remoteVideos" class="video-container"></div>

                        <video id="localVideo" autoplay muted
                            class="position-absolute shadow border border-white tw-rounded-xl"
                            style="width: 200px; bottom: 100px; right: 20px; z-index: 10;"></video>

                        <div class="position-absolute bottom-0 start-50 translate-middle-x tw-mb-4 tw-flex tw-gap-3 tw-bg-black/50 tw-backdrop-blur tw-rounded-full tw-px-4 tw-py-3 tw-shadow-lg" style="z-index: 11;">
                            <button class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-white/10 tw-text-white tw-border-0 hover:tw-bg-white/20" title="Settings" onclick="toggleSettingPanel()">
                                <i class="bi bi-gear-fill"></i>
                            </button>
                            <button id="btn-cam" class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-white/10 tw-text-white tw-border-0 hover:tw-bg-white/20" title="Toggle Camera" onclick="toggleCam()">
                                <i class="bi bi-camera-video-fill"></i>
                            </button>
                            <button id="btn-mic" class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-white/10 tw-text-white tw-border-0 hover:tw-bg-white/20" title="Toggle Mic" onclick="toggleMic()">
                                <i class="bi bi-mic-fill"></i>
                            </button>
                            <button id="btn-scrn-start" class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-white/10 tw-text-white tw-border-0 hover:tw-bg-white/20" onclick="startScreenShare()" style="display: block;">
                                <i class="bi bi-display-fill"></i>
                            </button>
                            <button id="btn-scrn-stop" class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-red-500 tw-text-white tw-border-0" onclick="stopScreenShare()" style="display: none;">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <button class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-red-500 tw-text-white tw-border-0" title="Hang Up" onclick="toggleControl()">
                                <i class="bi bi-telephone-x-fill"></i>
                            </button>
                        </div>

                        <div id="settingPanel" class="position-absolute translate-middle-x tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-4"
                            style="display:flex; flex-direction:column; gap:.4rem; left: 50%; bottom: 20%; z-index: 11; width: 100%; max-width: 300px; height: 100%; max-height: 350px;">
                        </div>
                    </div>
                </div>

                <!-- กล่องแชท -->
                <div class="col-12 col-lg-7 tw-bg-white tw-rounded-2xl tw-shadow tw-flex tw-flex-col tw-overflow-hidden tw-min-h-0 tw-min-w-0" id="commu-box" style="display: flex;">
                    <div class="tw-flex tw-justify-between tw-items-center tw-px-4 tw-py-3 tw-border-b tw-border-slate-100">
                        <div class="tw-flex tw-items-center tw-gap-2">
                            <button class="d-lg-none d-block bg-transparent border-0 tw-text-xl" onclick="toggleChatRoom()"><i class="bi bi-list"></i></button>
                            <div id="chat-header" class="tw-font-bold tw-text-lg"></div>
                        </div>
                        <div class="tw-flex tw-gap-2" id="meet-box" style="display: none;">
                            <button id="btnVideoCall" class="tw-w-9 tw-h-9 tw-rounded-full tw-bg-slate-100 tw-border-0 hover:tw-bg-slate-200" onclick="toggleControl() ">
                                <i class="bi bi-telephone-fill"></i>
                            </button>
                            <button id="btnVideoCall" class="tw-w-9 tw-h-9 tw-rounded-full tw-bg-slate-100 tw-border-0 hover:tw-bg-slate-200" onclick="toggleControl() ">
                                <i class="bi bi-camera-video-fill"></i>
                            </button>
                        </div>
                    </div>

                    <div id="chat-box" class="tw-flex-1 tw-min-h-0 tw-px-4 tw-py-3 tw-overflow-y-auto">
                        <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                            <div class="text fs-5 tw-text-slate-400"><?= $lang['message'] ?></div>
                        </div>
                    </div>

                    <div class="tw-flex tw-gap-2 tw-px-4 tw-py-3 tw-border-t tw-border-slate-100">
                        <input class="form-control tw-rounded-full" type="text" id="chat-message" placeholder="<?= $lang['chatholder'] ?>" />
                        <button class="tw-w-11 tw-h-11 tw-rounded-full tw-bg-brand tw-text-white tw-border-0 tw-shrink-0 hover:tw-opacity-90" onclick="sendMessage()"><i class="bi bi-send"></i></button>
                    </div>
                </div>

                <!-- สมาชิก/ข้อมูลห้อง -->
                <div id="infomation-box" class="tw-w-full lg:tw-w-72 lg:tw-shrink-0 tw-bg-white tw-rounded-2xl tw-shadow tw-p-4 tw-overflow-y-auto tw-min-h-0">
                    <div class="tw-flex tw-flex-col tw-gap-2">
                        <div id="name-chat" class="tw-font-bold tw-text-lg"><?= $lang['unknown'] ?></div>
                        <h6 class="text-muted tw-text-sm tw-mt-2 tw-mb-1"><?= $lang['member'] ?></h6>
                        <div id="status-chat" class="tw-rounded-xl tw-bg-slate-50 tw-p-3 tw-text-slate-500 tw-text-sm">
                            -- <?= $lang['empty'] ?> --
                        </div>
                    </div>
                </div>

                <!-- Chatbot widget -->
                <div style="position: fixed; bottom: 6%; right: 3%; z-index: 1050;">
                    <button id="btn-bot" class="botmenu tw-shadow-lg" onclick="toggleChat()">
                        <i class="bi bi-robot px-1"></i>
                    </button>
                </div>

                <div id="chatBotBox" class="chat-bot-box tw-rounded-2xl tw-shadow-xl tw-overflow-hidden" style="display: none;">
                    <div class="tw-flex tw-justify-between tw-items-center tw-bg-brand tw-text-white tw-px-3 tw-py-2">
                        <div class="tw-font-medium"><?= $lang['bot'] ?></div>
                        <button class="border-0 bg-transparent tw-text-white" onclick="toggleChat()" onkeypress="if(event.key === 'Escape') toggleChat()"><i class="bi bi-x-lg px-1"></i></button>
                    </div>
                    <div id="chatMessages" class="tw-p-3" style="height: 300px; overflow-y: auto;"></div>
                    <div class="tw-flex tw-gap-2 tw-p-2 tw-border-t tw-border-slate-100">
                        <input class="form-control tw-rounded-full" type="text" id="chatInput" placeholder="<?= $lang['chatholder'] ?>" onkeypress="if(event.key === 'Enter') sendMessageToBot()">
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
