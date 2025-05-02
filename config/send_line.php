<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['line_token'] ?? '';
    $message = $_POST['line_message'] ?? '';

    if (!$token || !$message) {
        echo "❌ โปรดกรอก Token และข้อความ";
        exit;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=" . $message);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-type: application/x-www-form-urlencoded",
        "Authorization: Bearer " . $token,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "✅ ส่งไปยัง LINE เรียบร้อยแล้ว";
}
?>
