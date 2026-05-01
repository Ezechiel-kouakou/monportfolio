<?php
header("Content-Type: text/plain");
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
echo "Fichier demandé : " . $file . "\n";
if (empty($file)) die("Fichier manquant.");

$target = "http://localhost/video-local/" . $file;
echo "URL cible : " . $target . "\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mode debug : on capture au lieu de streamer

// Support du Range
if (isset($_SERVER['HTTP_RANGE'])) {
    curl_setopt($ch, CURLOPT_RANGE, str_replace('bytes=', '', $_SERVER['HTTP_RANGE']));
    echo "Range demandé : " . $_SERVER['HTTP_RANGE'] . "\n";
}

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$info = curl_getinfo($ch);

echo "HTTP code : " . $httpCode . "\n";
echo "Erreur cURL : " . ($curlError ?: "aucune") . "\n";
echo "IP connectée : " . $info['primary_ip'] . "\n";
echo "Taille reçue : " . $info['size_download'] . " bytes\n";
echo "Content-Type reçu : " . $info['content_type'] . "\n";

if ($result === false) {
    echo "ÉCHEC : curl_exec a retourné false\n";
} else {
    echo "SUCCÈS : " . strlen($result) . " bytes reçus\n";
}

curl_close($ch);