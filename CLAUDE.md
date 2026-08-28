# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

A PHP LMS (e-learning platform) built without a framework — plain PHP pages with `mysqli`, PHP-`include`-based templating, Bootstrap 5 for UI, and a Ratchet/ReactPHP WebSocket server for real-time chat/video-call signaling. Runs under XAMPP (Apache + MySQL) on Windows at `C:\xampp\htdocs\lms`, served at `http://localhost/lms/`.

## Commands

There is no build step, bundler, or test suite — this is server-rendered PHP with vanilla JS/CSS loaded directly by the browser.

- **Install PHP deps:** `composer install` (deps: `cboden/ratchet`, `setasign/fpdf`, `phpmailer/phpmailer`)
- **Lint a single PHP file:** `php -l pages/somefile.php` — run this after editing any `.php` file (or any `.html` file under `include/` that contains embedded `<?php ?>`, e.g. `include/scriptjs-*.html`, since those are `include`'d directly into PHP pages)
- **Run the app:** start Apache/MySQL via XAMPP; there is no dev server to launch separately
- **Run the chat/WebSocket server:** `php config/chat-server.php` (listens on port 8085). In production it runs as a Windows service named `.RTCServerLMS`, managed via `services/service.bat` (install/uninstall/check status using NSSM) — check whether that service is already running before starting the script manually, to avoid a port conflict
- **Database:** MySQL database `lms_e_learning`; schema/seed dump lives at `lms_e_learning_22072026.sql` in the repo root. Connection settings (`localhost`/`root`/no password/port 3306) are hardcoded in `config/connect.php`

## Architecture

### Page structure — every page follows the same include skeleton

A page under `pages/*.php` is not a standalone HTML document; it's assembled from shared includes in this order:

```php
<?php include '../components/session.php'; checkLogin(); ?>
<!DOCTYPE html>
<html lang="<?= $langCode ?>">
<?php include "../include/ref.html"; ?>      <!-- CDN links: Bootstrap, Bootstrap Icons -->
<?php include "../include/style.html"; ?>    <!-- ALL page CSS lives here, gated by :root tokens -->
<head>...</head>
<body>
    <?php include "../include/header.php"; ?>
    <div class="d-flex" style="min-height: 100vh;">
        <?php include "../components/sidemenu.php"; ?>
        <div id="main-content" class="flex-grow-1" style="transition: all 0.3s ease;">
            <div class="page-wrap"> ... page content ... </div>
        </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>              <!-- global JS helpers -->
    <?php include "../include/scriptjs-<pagename>.html"; ?>   <!-- page-specific JS -->
</body>
</html>
```

Each page has a matching `include/scriptjs-<pagename>.html` for its JS. Because these `.html` files are `include`'d from PHP, they can (and do) contain `<?php ?>` blocks — the standard pattern for injecting localized strings safely into JS is `<?= json_encode($lang['key'], JSON_UNESCAPED_UNICODE) ?>`.

### Auth, session, and i18n — `components/session.php`

Included at the top of every protected page. `checkLogin()` redirects to `login.php` if `$_SESSION['user_id']` isn't set. This same file also:
- Loads the active language file (`lang/th.php` or `lang/en.php`, session-persisted via `?lang=` query param) into `$lang`, defaulting to English
- Reads theme colors (`bg`, `bgbar`, `bgside`, `text`, `button`) from session/POST for the user-customizable color scheme (see `pages/color.php`)

Role gating is done inline in `components/sidemenu.php` by checking `$_SESSION['user']['is_admin']` — there's no dedicated permissions layer. Admin-only nav items (certificate, user/student/quiz/access management, system settings) are wrapped in that one `if`.

### Design system — `include/style.html`

All CSS for the entire app lives in this single file, organized by page in commented sections. It re-skins Bootstrap globally via `:root` CSS variable overrides (`--bs-primary`, `--bs-border-radius`, etc.) so plain Bootstrap classes automatically match the theme, plus custom design tokens (`--color-primary`, `--color-ink`, `--radius-md`, `--shadow-sm`, etc.) and reusable component classes shared across pages (`.page-wrap`, `.page-title`, `.panel`, `.toolbar`, `.result-stats`/`.result-stat`, `.pagination-bar`, `.skeleton-card`, etc.). When redesigning a page, prefer reusing an existing class from another page over inventing new CSS.

**Known cascade gotcha:** Bootstrap utility classes like `.d-flex` use `!important`, which silently overrides an element's inline `style.display` set by JS. When a container's visibility is toggled via JS (`style.display = 'none'/'block'`), never put flex/layout classes directly on that same element — put them on an inner wrapper div instead, and leave the JS-toggled element as a plain block container.

### Backend endpoints — `config/*.php`

Not a REST API in any formal sense — each file is a standalone script hit directly via `fetch()`, typically doing one `mysqli` query and echoing JSON (or a redirect/HTML fragment). Naming conventions to know:
- `Fetch_*.php` — read/list endpoints returning JSON
- `Find_*.php` — search/filter endpoints
- `chat-*.php` — chat REST endpoints (rooms, messages, access) used alongside the WebSocket server for anything not needing to be realtime (history load, room CRUD)
- `*_create.php` / `*_edit.php` / `*_deleted.php` — CRUD actions per entity (course, exam, mycourse, user)
- `connect.php` — the single `mysqli` connection (`$conn`), included via `global $conn` wherever needed
- `error_log.php` — `log_error()` / `log_action()`, write to `log_error`/`log_action` DB tables; call sites read `$_SESSION['username']` for attribution

Queries are built with raw string interpolation in many places (not universally parameterized) — check existing patterns in the specific file you're editing before assuming `mysqli::prepare` is used everywhere.

### Chat & video calling

Realtime chat and WebRTC video-call signaling go through `config/chat-server.php` (Ratchet `WsServer` on port 8085), driven from `pages/chat.php` / `include/scriptjs-chat.html`. Message types handled by the server: `join`, `new-peer`, `offer`/`answer`/`candidate` (WebRTC signaling, routed by `target_id`), `chat` (persisted to `chat_messages` table, broadcast to the room), `leave`. Non-realtime chat data (room list, history, membership) goes through the `config/chat-*.php` REST endpoints instead.

### Certificates

`pages/certificate.php` lets admins bulk-generate certificates: pick a template (flat PNG files in `Templates/`), select students, POST names + template to `config/course-certificate.php`, which overlays text onto the template PNG via FPDF and returns a zip of PDFs. Generated files land in `certificates/` (gitignored) and `backup/`/`logs/` are also gitignored — don't assume anything written there is tracked.

### Global JS helpers — `include/scriptjs.html`

Included on every page after `header.php`; provides `showNotify(message)` (styled toast — use this instead of `alert()` in any new/edited JS), `showLoading()`/`hideLoading()` (fullscreen overlay), `showLoadingById(id)`/`hideLoadingById(id)` (scoped overlay), and the sidebar collapse/expand toggle wiring.


# UI / Frontend Conventions

เอกสารนี้เก็บ pattern และ convention ของหน้า PHP ในระบบ เพื่อให้ session/แชทใหม่ทำงานต่อได้แบบ consistent กับของเดิม ไม่ต้องออกแบบใหม่หรือเดาซ้ำ

## 1\. Page Skeleton

ทุกหน้าใช้โครงเดียวกับ `home.php` / `course.php`:

* ครอบด้วย `.page-wrap`
* หัวข้อหน้าใช้ `.page-title`
* sidebar / header / footer ใช้ include ชุดเดียวกันทุกหน้า ห้ามสร้าง layout แยก

## 2\. Stat Tiles

ถ้าหน้ามีข้อมูลสรุป (จำนวนรายการ, จำนวนที่เลือก ฯลฯ) ให้ reuse `.result-stats` (มาจาก `results.php`) แสดงเป็นตัวเลขแบบเรียลไทม์ ไม่ต้องออกแบบ stat block ใหม่

## 3\. Multi-step Flow (Panel Pattern)

เมื่อหน้าเป็นขั้นตอนต่อเนื่อง (เลือก A → เลือก B → ยืนยัน/ส่งออก):

* แต่ละขั้นห่อด้วย `.panel` หรือ `.panel-soft`
* ใส่ step-badge วงกลม (①②③...) หน้าแต่ละ panel เพื่อบอกลำดับ
* ถ้ามีตัวอย่าง/พรีวิวประกอบ ให้วางฝั่งขวาแบบ `sticky` ตาม scroll (เหมือน template preview panel ใน certificate.php)

## 4\. Notifications

* ห้ามใช้ `alert()` ในหน้าใหม่หรือหน้าที่แก้ไข — ใช้ `showNotify()` (toast) แทนเสมอ เพื่อธีมเดียวกันทั้งระบบ
* ทุกข้อความที่ใช้กับ `showNotify()` ต้องเพิ่ม lang key คู่กันทั้ง `lang/th.php` และ `lang/en.php` ห้ามเพิ่มแค่ฝั่งเดียว

## 5\. Search / Client-side Filter

* ถ้าหน้ามีตารางที่ต้องค้นหา/กรอง ให้ทำแบบ client-side filter (ตามรหัส/ชื่อ)
* รายการที่ผู้ใช้เลือกไว้แล้ว **ต้องไม่หาย** ตอนพิมพ์ค้นหา (filter เฉพาะการแสดงผล ไม่แตะ state ที่เลือกไว้)
* ถ้าค้นหาแล้วไม่พบ ให้แสดงข้อความแจ้งเตือน เช่น "ไม่พบรายชื่อที่ค้นหา"

## 6\. Form Elements

* Checkbox ใน list/table ใช้ class `form-check-input` เท่านั้น
* ห้ามใช้ pattern แบบ `form-check w-75 h-75` (เป็น bug ที่เจอและแก้ไปแล้วใน certificate.php)
* ตัดคอลัมน์ตารางที่ไม่มีข้อมูล/ว่างเปล่าออกเสมอ อย่าปล่อยทิ้งไว้

## 7\. Backward Compatibility Rule

เวลาปรับ layout หน้าเดิม (refactor UI แต่ logic เดิมทำงานอยู่):

* ห้ามเปลี่ยน `id` ขององค์ประกอบที่ JS เดิมอ้างอิงอยู่ (เช่น select/list/table ids)
* ห้ามเปลี่ยนชื่อ/signature ของฟังก์ชัน global ที่มีอยู่แล้ว (เช่น `Export()`, `preview()`)
* ห้ามเปลี่ยนค่า/format ของ checkbox value หรือ endpoint ที่ backend เดิมพึ่งพาอยู่
* ทดสอบผ่านเบราว์เซอร์จริงก่อนถือว่าเสร็จ: โหลดหน้า, การทำงานหลักครบ (dropdown/preview/filter/validation), ไม่มี error ใน console

## 8\. Reference Implementation

`pages/certificate.php` คือหน้าอ้างอิงล่าสุดที่ทำตาม convention ทั้งหมดข้างต้นครบถ้วน ใช้เป็นตัวอย่างเวลาจะปรับหน้าอื่นให้ตรง pattern เดียวกัน


