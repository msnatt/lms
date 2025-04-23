<?php
session_start();
$username = $_SESSION['username'] ?? 'guest';
$uploadDir = "../temp/$username/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = basename($_FILES['file']['name']);
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destination)) {
        echo json_encode(['success' => true, 'results' => $destination, 'filename' => $fileName]);
    } else {
        echo json_encode(['success' => false, 'results' => 'Failed to move file', 'filename' => $fileName]);
    }
    exit;
}
?>
