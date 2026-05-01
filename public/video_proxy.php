<?php
// video_proxy.php sur l'App Service Azure
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: video/mp4");

$file = $_GET['file'] ?? '';
if (!$file) exit;

// On appelle ta VM qui, elle, a l'accès à Penguin
$vm_bridge_url = "http://20.199.14.132/video-local/" . $file;

$handle = fopen($vm_bridge_url, "rb");
if ($handle) {
    while (!feof($handle)) {
        echo fread($handle, 8192);
        flush();
    }
    fclose($handle);
}