<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header('Content-Type: application/json');

$remote_url = 'https://penguin.tailc4a1d9.ts.net/api/get_data.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo $response;
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false, 
        "message" => "Le proxy n'a pas pu joindre ton serveur local (Code: $http_code). Vérifie que ton PC est allumé et Tailscale connecté."
    ]);
}