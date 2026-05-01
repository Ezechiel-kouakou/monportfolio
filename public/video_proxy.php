<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

$target = "http://100.65.154.19:8082/" . $file;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 0); // Pas de timeout pour les gros fichiers

// Envoyer les headers de réponse avant le body
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header) {
    $lower = strtolower($header);
    // Transmettre uniquement les headers utiles
    if (str_starts_with($lower, 'content-type:') ||
        str_starts_with($lower, 'content-length:') ||
        str_starts_with($lower, 'accept-ranges:') ||
        str_starts_with($lower, 'content-range:')) {
        header(trim($header));
    }
    return strlen($header);
});

// Streamer directement vers le client
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
    echo $data;
    flush();
    return strlen($data);
});

// Support du Range (lecture partielle pour la vidéo)
if (isset($_SERVER['HTTP_RANGE'])) {
    curl_setopt($ch, CURLOPT_RANGE, str_replace('bytes=', '', $_SERVER['HTTP_RANGE']));
    http_response_code(206);
}

$ok = curl_exec($ch);

if (!$ok) {
    http_response_code(502);
    header("Content-Type: text/plain");
    echo "Erreur cURL : " . curl_error($ch);
}

curl_close($ch);