<?php
// Autorise ton site Front-End (Vue.js)
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: application/json; charset=UTF-8");

// Nom du fichier qui sert de cache local sur Azure
$cache_file = 'data_cache.json';

if (file_exists($cache_file)) {
    // On lit le fichier JSON stocké localement sur le serveur Azure
    echo file_get_contents($cache_file);
} else {
    // Message si le Penguin n'a pas encore envoyé de données
    echo json_encode([
        "success" => false,
        "message" => "En attente de synchronisation avec le serveur local (Penguin)."
    ]);
}