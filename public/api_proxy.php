<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (empty($referer) || strpos($referer, 'ezechielkouakou.fr') === false) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "message" => "Accès direct interdit. Ce flux est réservé au portfolio."
    ]);
    exit;
}

$cache_file = 'data_cache.json';

if (file_exists($cache_file)) {
 
    $data = file_get_contents($cache_file);

    if (!empty($data)) {
        echo $data;
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Le fichier de cache est vide."
        ]);
    }
} else {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "En attente de synchronisation avec le serveur Penguin."
    ]);
}
?>