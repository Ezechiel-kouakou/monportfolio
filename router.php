<?php
$path = ltrim($_SERVER["REQUEST_URI"], '/');
if ($path === 'traitment.php' || $path === 'debug.php') {
    return false; 
}
if (file_exists("dist/$path") && is_file("dist/$path")) {
    $mimes = [
        'js' => 'application/javascript', 
        'css' => 'text/css', 
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg'
    ];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (isset($mimes[$ext])) {
        header("Content-Type: " . $mimes[$ext]);
    }
    readfile("dist/$path");
    exit;
}
readfile("dist/index.html");
?>