<?php
// stream.php sur Azure
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: video/mp4");

$video = $_GET['v'] ?? '';
if (empty($video)) die("Pas de video");

$url = "http://20.199.14.132/video-local/" . $video;

// Configuration du contexte pour simuler un appel local
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Host: localhost\r\n" // On fait croire à Apache que c'est un appel local
    ]
];

$context = stream_context_create($opts);

// On lance le flux
$fp = fopen($url, 'rb', false, $context);

if ($fp) {
    while (!feof($fp)) {
        echo fread($fp, 8192);
        flush();
    }
    fclose($fp);
} else {
    header("HTTP/1.1 502 Bad Gateway");
    echo "Le pont Azure n'arrive pas à joindre la VM.";
}