<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

// ON GARDE LE NOM DNS (pour que OpenResty soit content)
$host = "penguin.tailc4a1d9.ts.net";
$source_url = "https://" . $host . "/" . $file;

// MAIS ON DIT À PHP QUE CE NOM CORRESPOND À TON IP TAILSCALE
$context = stream_context_create([
    "ssl" => ["verify_peer" => false, "verify_peer_name" => false],
    "http" => [
        "header" => "Host: $host\r\n", // On force le header Host
        "timeout" => 20
    ]
]);

// On essaie d'ouvrir via l'IP directement mais avec le header du nom DNS
$ip_url = "https://100.65.154.19/" . $file;
$stream = @fopen($ip_url, 'rb', false, $context);

if ($stream) {
    header("Content-Type: video/mp4");
    fpassthru($stream);
    fclose($stream);
} else {
    echo "Erreur : OpenResty sur Penguin refuse toujours la connexion (404 ou 403).";
}