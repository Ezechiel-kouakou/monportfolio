<?php
// Désactiver la compression Gzip qui casse le streaming vidéo
if (function_exists('apache_setenv')) { @apache_setenv('no-gzip', 1); }
@ini_set('zlib.output_compression', 'Off');

header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$video = $_GET['v'] ?? '';
if (empty($video)) {
    header("HTTP/1.1 400 Bad Request");
    die("Nom de vidéo manquant.");
}

$url_vm = "http://20.199.14.132/video-local/" . $video;

// On vérifie si la VM répond avant de lancer le flux
$headers = @get_headers($url_vm);
if(!$headers || strpos($headers[0], '404') !== false) {
    header("HTTP/1.1 404 Not Found");
    die("La vidéo n'est pas accessible sur le pont Azure/Penguin.");
}

header("Content-Type: video/mp4");

// Vider tous les tampons PHP pour envoyer les données en direct
while (ob_get_level()) ob_end_clean();

$fp = fopen($url_vm, 'rb');
if ($fp) {
    // On lit par petits morceaux pour ne pas saturer la RAM
    while (!feof($fp)) {
        echo fread($fp, 1024 * 8); // 8kb par 8kb
        flush(); 
    }
    fclose($fp);
}