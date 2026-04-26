<?php
ini_set('display_errors', 0);

function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

loadEnv(__DIR__ . '/../.env');

$token_secret = $_ENV['SYNC_TOKEN'] ?? null;

if (!$token_secret || !isset($_GET['token']) || $_GET['token'] !== $token_secret) {
    http_response_code(403);
    die("Accès refusé : Sécurité Token invalide");
}
$json_recu = file_get_contents('php://input');

if ($json_recu) {
    if (file_put_contents('data_cache.json', $json_recu)) {
        echo "Synchronisation réussie !";
    } else {
        http_response_code(500);
        echo "Erreur d'écriture sur le serveur Azure.";
    }
} else {
    echo "Aucune donnée reçue.";
}