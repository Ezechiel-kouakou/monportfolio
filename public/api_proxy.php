<?php
// --- CONFIGURATION DEBUG & ERREURS ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$debug = [];
$host = 'penguin.tailc4a1d9.ts.net';
$ip = '100.65.154.19'; // Ton IP Tailscale Penguin
$url = 'https://' . $host . '/api/get_data.php';

$debug['config'] = [
    "target_url" => $url,
    "forced_ip" => $ip,
    "php_version" => PHP_VERSION
];

$ch = curl_init();

// --- LA CLÉ : FORCER LA RÉSOLUTION DNS EN INTERNE ---
// On dit à PHP d'associer le domaine à l'IP Tailscale pour le port 443 (HTTPS)
curl_setopt($ch, CURLOPT_RESOLVE, ["$host:443:$ip"]); 

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Capture des logs détaillés de cURL
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);

// Extraction des logs de communication
rewind($verbose);
$debug['network_logs'] = stream_get_contents($verbose);
fclose($verbose);

$debug['http_code'] = $info['http_code'];
$debug['curl_error'] = $error;

// Test de connectivité brute (Port 443 sur l'IP Tailscale)
$connection = @fsockopen($ip, 443, $errno, $errstr, 5);
$debug['raw_tcp_check'] = [
    "connected" => is_resource($connection),
    "error" => $errstr
];
if(is_resource($connection)) fclose($connection);

// --- RÉPONSE ---
if ($response !== false && $info['http_code'] === 200) {
    // Si ça marche, on renvoie juste les données (ou le debug si tu préfères)
    echo $response; 
} else {
    echo json_encode([
        "success" => false,
        "message" => "Échec de la liaison avec le Penguin",
        "debug" => $debug
    ], JSON_PRETTY_PRINT);
}