<?php
// stream.php sur Azure
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$video = $_GET['v'] ?? '';
if (empty($video)) die("Nom de vidéo manquant.");

// C'est ici que la magie opère : Azure appelle ta VM (20.199.14.132)
// Ta VM, grâce à Apache ProxyPass, va chercher la vidéo sur Penguin via Tailscale
$url_vm = "http://20.199.14.132/video-local/" . $video;

header("Content-Type: video/mp4");

// On streame le contenu sans le stocker sur Azure
$fp = fopen($url_vm, 'rb');
if ($fp) {
    fpassthru($fp);
    fclose($fp);
}