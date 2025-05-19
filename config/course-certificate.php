<?php
require('../vendor/fpdf/fpdf.php');

// รับข้อมูล JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$names = $data['names'];
$template = $data['template'];

// โฟลเดอร์สำหรับ certificate
$cert_folder = '../certificates/';
if (!is_dir($cert_folder)) {
    mkdir($cert_folder, 0777, true);
}

// วนลูปสร้าง PDF
$pdf_files = [];
foreach ($names as $name) {
    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->Image("../templates/$template", 0, 0, 297, 210);

    $pdf->AddFont('THSarabun','','THSarabun.php');
    $pdf->SetFont('THSarabun','',36);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(0, 95);
    $pdf->Cell(297, 10, iconv('UTF-8', 'TIS-620', $name), 0, 1, 'C');

    $safeName = preg_replace('/[^a-zA-Z0-9ก-๙\s_-]/u', '', $name);
    $filePath = $cert_folder . $safeName . ".pdf";
    $pdf->Output('F', $filePath);
    $pdf_files[] = $filePath;
}

// สร้าง ZIP
$zip_name = $cert_folder . "certificates_" . time() . ".zip";
$zip = new ZipArchive();
if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
    foreach ($pdf_files as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();
}

// ส่งลิงก์ zip กลับ
echo json_encode(['zip' => $zip_name]);