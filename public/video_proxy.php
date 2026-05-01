<?php
/* --- CONFIGURATION DES ENTÊTES --- */
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Access-Control-Allow-Methods: GET");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

// 1. On définit l'IP et le Nom DNS de ta capture
$ip_penguin = "100.65.154.19";
$host_dns = "penguin.tailc4a1d9.ts.net";

// 2. On crée l'URL en utilisant l'IP pour éviter l'erreur DNS (getaddrinfo)
// Mais on garde le HTTPS car ton OpenResty semble configuré en SSL
$source_url = "https://" . $ip_penguin . "/" . $file;

// 3. LE SECRET : On force le header "Host" pour tromper OpenResty
// On lui envoie l'IP, mais on lui dit "Je suis le domaine .ts.net"
$context = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false
    ],
    "http" => [
        "header" => "Host: " . $host_dns . "\r\n", 
        "timeout" => 20,
        "follow_location" => 1
    ]
]);

// 4. Tentative d'ouverture
$stream = @fopen($source_url, 'rb', false, $context);

if ($stream) {
    header("Content-Type: video/mp4");
    fpassthru($stream);
    fclose($stream);
} else {
    header("Content-Type: text/plain; charset=UTF-8");
    $last_error = error_get_last();
    echo "--- ÉCHEC DU PONT AZURE-PENGUIN ---\n";
    echo "L'IP répond mais OpenResty rejette la requête.\n";
    echo "Erreur PHP : " . ($last_error['message'] ?? "Aucune réponse");
}