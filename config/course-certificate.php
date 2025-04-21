<?php
require('../vendor/fpdf/fpdf.php'); // ถ้าไม่ได้ใช้ Composer

$name = $_POST['name'];
$template = $_POST['template'];

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image("../templates/$template", 0, 0, 297, 210);

// ตั้งค่า font
$pdf->AddFont('THSarabun','','THSarabun.php'); // ใช้ฟอนต์ภาษาไทย ถ้ามี
$pdf->SetFont('THSarabun','',36);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(0, 95);
$pdf->Cell(297, 10, iconv('UTF-8', 'TIS-620', $name), 0, 1, 'C');

// บันทึกเป็น PDF
$outputPath = "../certificates/$name.pdf";
$pdf->Output('F', $outputPath);

// แสดงผล
echo "<h3>Certificate สำหรับ <strong>$name</strong> ถูกสร้างแล้ว</h3>";
echo "<a href='$outputPath' target='_blank'>ดาวน์โหลด Certificate</a>";
