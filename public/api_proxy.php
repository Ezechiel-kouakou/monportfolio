<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: application/json; charset=UTF-8");

$cache_file = 'data_cache.json';

$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (empty($referer) || strpos($referer, 'ezechielkouakou.fr') === false) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "message" => "Accès direct interdit."
    ]);
    exit;
}

if (file_exists($cache_file)) {
    echo file_get_contents($cache_file);
} else {
    echo json_encode([
        "success" => false,
        "message" => "En attente de synchronisation avec le serveur local (Penguin)."
    ]);
}