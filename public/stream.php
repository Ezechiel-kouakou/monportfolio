<?php
// Désactiver les limites de temps et la compression
set_time_limit(0);
if (function_exists('apache_setenv')) { @apache_setenv('no-gzip', 1); }
@ini_set('zlib.output_compression', 'Off');

// Headers de partage
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: video/mp4");

$video = $_GET['v'] ?? '';
if (empty($video)) {
    die("Nom de vidéo manquant.");
}

// L'URL de ta VM (qui répond 200 OK en local)
$url_vm = "http://20.199.14.132/video-local/" . $video;

// Nettoyage du tampon de sortie
while (ob_get_level()) ob_end_clean();

// Ouverture directe du flux vers la VM
$fp = fopen($url_vm, 'rb');

if ($fp) {
    // On transmet les données par blocs de 8 Ko
    while (!feof($fp)) {
        echo fread($fp, 8192);
        flush();
    }
    fclose($fp);
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Impossible d'ouvrir le flux vidéo vers la VM.";
}