<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

$target = "http://100.65.154.19:8082/" . $file;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // On affiche directement
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: penguin.tailc4a1d9.ts.net"
]);

// On définit le type de contenu avant de lancer
header("Content-Type: video/mp4");

if (!curl_exec($ch)) {
    header("Content-Type: text/plain");
    echo "Erreur cURL : " . curl_error($ch);
}

curl_close($ch);