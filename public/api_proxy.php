<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

$ip = '100.65.154.19';
$host = 'penguin.tailc4a1d9.ts.net';
$results = [];

// 1. Test de connectivité brute (TCP SYN)
function test_port($ip, $port) {
    $connection = @fsockopen($ip, $port, $errno, $errstr, 3);
    if (is_resource($connection)) {
        fclose($connection);
        return "OUVERT (Success)";
    }
    return "FERMÉ (Reason: $errstr)";
}

$results['tcp_check'] = [
    "port_80_http" => test_port($ip, 80),
    "port_443_https" => test_port($ip, 443)
];

// 2. Test cURL détaillé sur le port qui semble répondre
$results['curl_attempt'] = [];
$ports_to_test = [80, 443];

foreach ($ports_to_test as $port) {
    $protocol = ($port === 443) ? "https" : "http";
    $ch = curl_init();
    $url = "$protocol://$host/api/get_data.php";
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RESOLVE, ["$host:$port:$ip"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    
    $resp = curl_exec($ch);
    rewind($verbose);
    
    $results['curl_attempt']["port_$port"] = [
        "http_code" => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        "error" => curl_error($ch),
        "log" => stream_get_contents($verbose)
    ];
    fclose($verbose);
    curl_close($ch);
}

// 3. Vérification des interfaces réseau Azure
$results['azure_env'] = [
    "tailscale_interface_guess" => shell_exec("ip addr | grep tailscale") ?? "Non visible par PHP",
    "routing_table_check" => shell_exec("route -n | grep 100.") ?? "Pas de route vers Tailscale via PHP"
];

echo json_encode($results, JSON_PRETTY_PRINT);