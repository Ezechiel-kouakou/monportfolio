<?php
// --- CONFIGURATION DEBUG ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

$debug_info = [];
$remote_url = 'https://penguin.tailc4a1d9.ts.net/api/get_data.php';

// 1. Vérification de l'environnement Azure
$debug_info['server_ip'] = $_SERVER['SERVER_ADDR'] ?? 'Inconnue';
$debug_info['php_version'] = PHP_VERSION;

// 2. Test de résolution DNS brute
$host = 'penguin.tailc4a1d9.ts.net';
$debug_info['dns_lookup'] = gethostbyname($host); 
// Si dns_lookup == $host, c'est que le DNS ne résout rien du tout

// 3. Exécution cURL avec verbeux
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// On capture les logs verbeux dans un flux temporaire
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);

// Récupération des logs de debug
rewind($verbose);
$debug_info['curl_verbose_logs'] = stream_get_contents($verbose);
fclose($verbose);

$debug_info['http_code'] = $http_code;
$debug_info['curl_error'] = $curl_error;

// 4. Réponse finale
echo json_encode([
    "success" => false,
    "debug" => $debug_info,
    "raw_response_preview" => substr($response, 0, 100)
], JSON_PRETTY_PRINT);