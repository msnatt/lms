<?php
$folder = '../assets/images/bg_cards/'; // เปลี่ยนตามชื่อโฟลเดอร์ที่เก็บรูป
$files = glob($folder . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
$filenames = [];

foreach ($files as $file) {
    $filenames[] = basename($file); // เอาเฉพาะชื่อไฟล์ ไม่รวม path
}

echo json_encode($filenames);
