<?php
// stream.php sur Azure
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: video/mp4");

// 1. Force la désactivation du tampon de sortie PHP pour éviter l'attente
while (ob_get_level()) ob_end_clean();

$video = $_GET['v'] ?? '';
if (empty($video)) die("Pas de video");

$url = "http://20.199.14.132/video-local/" . $video;

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Host: localhost\r\n"
    ]
];

$context = stream_context_create($opts);

$fp = fopen($url, 'rb', false, $context);

if ($fp) {
    // 2. On lit par blocs plus petits (4096 au lieu de 8192) pour que le lecteur reçoive vite les premières images
    while (!feof($fp)) {
        echo fread($fp, 4096);
        flush(); // Envoie immédiatement ce qui vient d'être lu
    }
    fclose($fp);
} else {
    header("HTTP/1.1 502 Bad Gateway");
    echo "Le pont Azure n'arrive pas à joindre la VM.";
}