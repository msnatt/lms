<?php
// ห้าม commit ไฟล์นี้ขึ้น git — อยู่ใน .gitignore แล้ว
return [
    'host'     => 'smtp.gmail.com',
    'username' => 'ftatm.it.1@gmail.com',
    'password' => '',           // <-- ใส่ app password ตัวใหม่ที่ rotate แล้ว (ตัวเก่าหลุดขึ้น git ไปแล้ว ต้อง revoke)
    'secure'   => 'tls',
    'port'     => 587,
    'from'     => 'FTA@gmail.com',
    'fromname' => 'FIELDTECH AUTOMATION CO.,LTD.',
];
