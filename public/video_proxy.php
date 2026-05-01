<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

$target = "http://localhost/video-local/" . $file;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);

// Force le bon VirtualHost Apache qui contient le ProxyPass
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: serverazure.tailc4a1d9.ts.net"
]);

// Transmet les headers utiles au client
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header) {
    $lower = strtolower($header);
    if (str_starts_with($lower, 'content-type:') ||
        str_starts_with($lower, 'content-length:') ||
        str_starts_with($lower, 'accept-ranges:') ||
        str_starts_with($lower, 'content-range:')) {
        header(trim($header));
    }
    return strlen($header);
});

// Stream directement vers le client
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
    echo $data;
    flush();
    return strlen($data);
});

// Support Range pour scrubbing vidéo
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