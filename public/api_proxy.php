<?php
// Désactiver l'affichage des erreurs HTML pour ne pas casser le JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$remote_url = 'https://penguin.tailc4a1d9.ts.net/api/get_data.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur cURL : " . $curl_error
    ]);
} else if ($http_code !== 200) {
    echo json_encode([
        "success" => false,
        "message" => "Le serveur local a répondu avec le code : " . $http_code,
        "debug_url" => $remote_url
    ]);
} else {
    echo $response;
}