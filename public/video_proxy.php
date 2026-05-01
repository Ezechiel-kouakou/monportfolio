<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Erreur : Aucun fichier spécifié.");

// REMPLACE PAR L'IP TAILSCALE DE TON SERVEUR AZURE
$ip_azure_vpn = "100.72.255.10"; // <--- CHANGE CETTE IP
$target = "http://" . $ip_azure_vpn . "/video-local/" . $file;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Host: serverazure.tailc4a1d9.ts.net"]);

// Pour le débug, on affiche l'erreur si ça rate
curl_setopt($ch, CURLOPT_FAILONERROR, true);

header("Content-Type: video/mp4");

if (!curl_exec($ch)) {
    header("Content-Type: text/plain");
    echo "Erreur de routage interne Azure.\n";
    echo "Cible tentée : " . $target . "\n";
    echo "Détail : " . curl_error($ch);
}
curl_close($ch);