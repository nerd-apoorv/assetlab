<?php
$file = $_GET['file'];
$filepath = __DIR__ . '/media/' . $file;

if (file_exists($filepath)) {
    header('Content-Type: image/png');
    readfile($filepath);
    exit;
} else {
    http_response_code(404);
    echo "File not found.";
}
?>
