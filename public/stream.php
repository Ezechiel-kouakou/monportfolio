<?php
// On empêche PHP de limiter le temps d'exécution
set_time_limit(0);

// Désactivation de la compression qui bloque le streaming
if (function_exists('apache_setenv')) { @apache_setenv('no-gzip', 1); }
@ini_set('zlib.output_compression', 'Off');

header("Access-Control-Allow-Origin: *");
header("Content-Type: video/mp4");

$video = $_GET['v'] ?? '';
if (empty($video)) die();

$url = "http://20.199.14.132/video-local/" . $video;

// On vide tous les tampons de sortie de PHP
while (ob_get_level()) ob_end_clean();

$fp = fopen($url, 'rb');

if ($fp) {
    // On lit par petits blocs de 4 Ko pour une fluidité maximale
    while (!feof($fp)) {
        echo fread($fp, 4096);
        // La commande magique pour envoyer les données au navigateur MAINTENANT
        flush(); 
        if (connection_aborted()) break;
    }
    fclose($fp);
}