<?php
$file = $_GET['file'] ?? '';

if (empty($file) || !preg_match('/^video_[a-zA-Z0-9._-]+$/', $file)) {
    http_response_code(400);
    die("Fichier non valide.");
}

$penguin_url = "https://penguin.tailc4a1d9.ts.net/" . $file;


header('Content-Type: video/mp4');
header('Access-Control-Allow-Origin: *');

$stream = fopen($penguin_url, 'rb');
if ($stream) {
    fpassthru($stream);
    fclose($stream);
} else {
    http_response_code(404);
    echo "Vidéo introuvable sur le serveur source.";
}