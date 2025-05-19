<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['email_to'] ?? '';
    $message = $_POST['email_message'] ?? '';

    if (!$to || !$message) {
        echo "❌ โปรดกรอก Email และข้อความ";
        exit;
    }

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ft.experimenter@gmail.com';
        $mail->Password = 'ujvsgawhrkbwlaqq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('FTA@gmail.com', 'FIELDTECH AUTOMATION CO.,LTD.');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'แจ้งเตือนข้อความผ่าน E-mail';
        $mail->Body = nl2br($message);

        $mail->send();
        echo "✅ ส่ง Email สำเร็จ";
    } catch (Exception $e) {
        echo "❌ ส่ง Email ไม่สำเร็จ: " . $mail->ErrorInfo;
    }
}
?>
