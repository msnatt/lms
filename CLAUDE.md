# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A PHP e-learning LMS (course catalogue, video lessons, quizzes/exams, certificates, real-time chat/video-call, admin management) running on a classic XAMPP stack — no framework, no build step, no test suite. It is served from `C:\xampp\htdocs\lms` and accessed at `http://localhost/lms/`.

## Running it

- Start Apache + MySQL via XAMPP; the app is at `http://localhost/lms/` (`index.php` just redirects to `pages/home.php`).
- Database: MySQL, name `lms_e_learning`, connected via `mysqli` in `config/connect.php` (localhost / root / no password / port 3306). Import the schema+data from `lms_e_learning_22072026.sql` to get a working DB — it's the source of truth for table structure.
- PHP dependencies are managed by Composer (`composer.json` / `vendor/`): `cboden/ratchet` (WebSocket server), `setasign/fpdf` (certificate PDFs), `phpmailer/phpmailer` (email). Run `composer install` after cloning.
- `.vscode/launch.json` has Xdebug configs (port 9003) for step debugging against XAMPP's PHP.
- No JS package manager / bundler — `node_modules/bootstrap-icons` is the only JS dependency and is used purely for its font/CSS files, not built.

### Real-time chat / video-call server

Chat and WebRTC signaling run over a separate Ratchet WebSocket server, not through Apache:
- Entry point: `config/chat-server.php` — plain `php config/chat-server.php` starts a `Ratchet\Server\IoServer` listening on `ws://0.0.0.0:8085`.
- On Windows it's installed as a service (`.RTCServerLMS`) via `services/service.bat`, which wraps `nssm.exe` around `php.exe config/chat-server.php`. Use that script (menu: check/install/uninstall) to manage the service rather than running the PHP file directly in production.
- Message types handled: `join`, `new-peer`, `offer`/`answer`/`candidate` (WebRTC signaling relay), `chat` (persists to `chat_messages` table then broadcasts), `leave`.
- There's commented-out code for a TLS (`wss://`) variant using `React\Socket\SecureServer` with cert paths — currently disabled, plain `ws://` is live.

### No automated tests, linter, or build command exist in this repo.

## Architecture

### Page shell pattern (every page in `pages/` follows this)

```php
<?php
include '../components/session.php';   // session_start, $lang, theme colors, checkLogin(), logout()
checkLogin();                           // omit only on public pages: home.php, login.php, register.php, resetpass.php
?>
<html lang="<?= $langCode ?>">
<?php include "../include/ref.html"; ?>      <!-- <head>: Bootstrap 5.3.3 CDN, Bootstrap Icons, favicon -->
<?php include "../include/style.html"; ?>    <!-- ALL custom CSS for the whole app (two <style> blocks) -->
<head><title>...</title></head>
<body style="background-color: <?= $bg; ?>">
    <?php include "../include/header.php"; ?>        <!-- navbar, uses $bgbar, $lang, $_SESSION['user_id'] -->
    <div class="d-flex" style="min-height:100vh">
        <?php include "../components/sidemenu.php"; ?>  <!-- uses $bgside, gated admin links via $_SESSION['user']['is_admin'] -->
        <div id="main-content"> ... page content ... </div>
    </div>
    <?php include "../include/footer.php"; ?>
    <?php include "../include/scriptjs.html"; ?>          <!-- Bootstrap JS, sidebar toggle, showLoading()/hideLoading()/showNotify() globals -->
    <?php include "../include/scriptjs-<pagename>.html"; ?>  <!-- page-specific JS, one file per page -->
</body>
</html>
```

Because `ref.html`, `style.html`, `header.php`, `sidemenu.php`, `footer.php`, and `scriptjs.html` are shared by ~25 pages, **any edit to those files affects every page** — check ripple effects before changing them. Page-specific styling/behavior belongs in a page's own inline `<style>` or its dedicated `include/scriptjs-<page>.html`, never in the shared files.

`components/session.php` also owns:
- Language: `$_SESSION['lang']` (`th`/`en`), switchable via `?lang=th|en`; loads `lang/{code}.php` into `$lang[]`. `buildLangSwitchLink($targetLang)` preserves other query params.
- Theme colors: `$bg`, `$bgbar`, `$bgside`, `$text`, `$button` — read from session, overridable by POSTing those field names (used by the color-customization page), consumed across header/sidemenu/home.
- `checkLogin()` redirects to `login.php` if `$_SESSION['user_id']` isn't set; `logout()` logs the event to `log_login` then destroys the session.

### Data flow: PHP pages don't query the DB directly for page content

Pages render static HTML shells with empty containers/`<img>` tags with no `src`. All data comes from client-side `fetch()` calls (in the page's `include/scriptjs-<page>.html`) to JSON endpoints in `config/Fetch_*.php`, `config/Find_*.php`, etc. Those endpoints follow one consistent pattern:

```php
<?php
include "../config/no-crash.php";   // no-cache headers
include "../config/connect.php";    // opens $conn (mysqli)
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$sql = "SELECT ... FROM ... WHERE ...";
$result = $conn->query($sql);       // or prepare()/bind_param() when input is user-supplied
$options = [];
while ($row = $result->fetch_assoc()) { $options[] = $row; }
header('Content-Type: application/json');
echo json_encode($options);
$conn->close();
```

When an `<img id="...">` or similar element's `id` must match a DB column name exactly (e.g. home page slides/icons map 1:1 to `home_profile` columns `slide01..slide03`, `icon01..icon08`) — renaming one side without the other silently breaks the page. `config/connect.php` also calls `log_error()` (defined in `config/error_log.php`, writes to the `log_error` table) on connection failure.

### Auth & roles

- `user` table has `is_admin` (tinyint) — the only role flag; no granular RBAC. Admin-only UI (management pages, "create course" FAB, etc.) is gated by checking `$_SESSION['user']['is_admin'] == "1"` inline in the page, not via a shared guard function.
- Passwords are hashed with `password_verify()`/PHP's `password_hash()` (see `config/db_login.php`).
- `config/no-crash.php` disables caching on JSON endpoints — apply it to new `Fetch_*`/`Find_*` endpoints for consistency.

### Key tables (see `lms_e_learning_22072026.sql` for full DDL)

`user`, `course` (+ `course_access`, `course_student`, `course_schedule`, `course_points`), `unit`, `content`, `file`, `questions`/`choices`/`question_sets`/`user_answers`/`test_results` (exam system), `chat_rooms`/`chat_access`/`chat_messages`, `home_profile` (home page slides/icons/video), `department`/`faculty`, `log_action`/`log_error`/`log_login` (audit trail), `token_line` (LINE notify integration).

### Landing-page visual style (Tailwind-on-Bootstrap pattern, established on `pages/home.php`)

`home.php` was redesigned as a Hero + stacked-sections landing page while every other page still runs on Bootstrap 5.3.3 (shared via `ref.html`/`style.html`). To reuse this look on another page without breaking the shared Bootstrap chrome (navbar/sidebar/footer), follow the same recipe:

- **Load Tailwind scoped to that one page**, inside its own `<head>` block (not in `ref.html`/`style.html`), and neutralize the two ways it can collide with Bootstrap:
  ```html
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      prefix: 'tw-',                          // avoids clashing with Bootstrap's .container, .hidden, .fixed, .block, .border, etc.
      corePlugins: { preflight: false },      // preflight would reset Bootstrap's base styles app-wide
      theme: { extend: { colors: { brand: '#0284c7', brandink: '#0c4a6e' } } }  // blue/sky rebrand (see "Theme color migration" below) — copy this pair verbatim into any newly-migrated page
    }
  }
  </script>
  ```
  Every Tailwind class on the page must carry the `tw-` prefix (`tw-flex`, `tw-grid-cols-4`); responsive/state variants keep the prefix after the colon (`md:tw-grid-cols-4`, `hover:tw-scale-110`). Bootstrap classes (`d-flex`, `justify-content-center`, `carousel`, …) stay unprefixed and keep working as before.
- **Section rhythm**: full-bleed hero, then alternating-background stacked `<div>` sections (e.g. `tw-bg-slate-50` vs. page background) each wrapped in `tw-max-w-6xl tw-mx-auto tw-px-4 tw-py-10 md:tw-py-16`, with a heading (`tw-text-xl md:tw-text-2xl tw-font-bold`) + one-line subtext (`tw-text-slate-500`) per section instead of Bootstrap's `<br><br>` spacing.
- **Hero carousel**: keep Bootstrap's data-API carousel (`data-bs-ride`, `data-bs-target`, `.carousel-item.active`) untouched for behavior; make slides fill the viewport with `tw-object-cover` + a fixed-height wrapper (`tw-h-[55vh] md:tw-h-[70vh]`), and put a text/CTA overlay as a sibling `<div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-black/70 ... tw-pointer-events-none">` (with `tw-pointer-events-auto` on the inner CTA buttons) inside `.carousel-inner` — outside the individual `.carousel-item`s — so the overlay stays fixed while slides rotate underneath it.
- **Cards** (course cards, feature tiles): `tw-bg-white tw-rounded-xl tw-shadow tw-overflow-hidden tw-transition tw-duration-300 hover:tw-shadow-lg hover:-tw-translate-y-1`, image `tw-w-full tw-h-40 tw-object-cover` + `loading="lazy"`.
- **Grids**: `tw-grid tw-grid-cols-2 sm:tw-grid-cols-4 lg:tw-grid-cols-8` for icon strips, `tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4` for card lists.
- Keep any `<img id="...">` whose `id` is consumed by the data-loading JS (see the Data flow section above) exactly as-is when restyling — only change `class`/wrapper markup, never the `id`.
- New page-specific data endpoints (e.g. `config/Fetch_HomeCourse.php`) follow the same `Fetch_*.php` pattern described above, and new page-specific JS (loading state, empty-state fallback for a `fetch()`-filled grid) goes in that page's own `include/scriptjs-<page>.html`, guarded with `showLoading()`/`hideLoading()`.

#### Theme color migration: orange → blue/sky (in progress, page by page)

The app's original brand color was orange (`#F28222`, still baked into `include/style.html` as `.color-primary`, `.color-secondary`'s gray-brown, `.color-outline-primary`, and the global `input:focus { border: 2px solid #F28222; }`). The brand is moving to a **blue/sky palette** ahead of a logo change, rolled out one redesigned page at a time rather than as a single sitewide sweep — do not "fix" this by editing `include/style.html`'s shared rules; that would flip every unmigrated page at once.

- **Current values**: `brand: '#0284c7'` (Tailwind `sky-600`), `brandink: '#0c4a6e'` (`sky-900`) — set in the per-page Tailwind config block described above. `pages/home.php` and `pages/login.php` are migrated; every other page still renders the legacy orange via `include/style.html` until it goes through the same Tailwind-scoped redesign.
- Because `input:focus`'s orange border lives in the shared `style.html`, a migrated page with form inputs needs a page-scoped override with enough specificity to beat it — see `pages/login.php`'s `.login-card .form-control:focus { border-color: #0284c7; box-shadow: 0 0 0 .25rem rgba(2, 132, 199, .25); }`. Reuse that pattern (swap the class scope) rather than touching the shared rule.
- When migrating another page, swap its local `brand`/`brandink` values to the pair above (or reuse Tailwind's built-in `sky-*`/`blue-*` utilities directly) — don't reintroduce `#F28222`/`#5B5A59`.

### Known repo quirks worth knowing before touching related code

- `components/set_course.php` is lowercase on disk but referenced everywhere as `Set_Course.php` — harmless on Windows/XAMPP (case-insensitive FS) but would break on a case-sensitive deployment (Linux). Don't "fix" the casing in one place without checking all callers.
- `pages/home.php`'s original markup nested a stray `<head>` include; some pages construct `<head>` across two blocks (`ref.html`/`style.html` includes, then a second literal `<head>`) — this is intentional/tolerated by browsers, not a typo to silently reflow.
- `include/scriptjs.html` binds the sidebar-toggle listener to `#sidebar_btn`/`#sidebar` — guard for null before adding pages that might omit the header/sidebar includes.
- `config/mail-credentials.php` holds live SMTP credentials and is intentionally untracked — never commit it; treat `config/turn-credentials.php` (WebRTC TURN server creds, listed in `.gitignore`) the same way if it's reintroduced.
