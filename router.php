<?php
$path = ltrim($_SERVER["REQUEST_URI"], '/');
if (file_exists("dist/$path") && is_file("dist/$path")) {
    $mimes = ['js' => 'application/javascript', 'css' => 'text/css', 'svg' => 'image/svg+xml'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (isset($mimes[$ext])) header("Content-Type: $mimes[$ext]");
    readfile("dist/$path");
} else {
    readfile("dist/index.html");
}
?>