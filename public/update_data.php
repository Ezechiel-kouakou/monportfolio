<?php
// Désactiver l'affichage des erreurs pour ne pas polluer le JSON
ini_set('display_errors', 0);

// Le token doit être IDENTIQUE à celui de ton script .sh
$token_secret = "ezechiel_secure_token_2024"; 

if (!isset($_GET['token']) || $_GET['token'] !== $token_secret) {
    http_response_code(403);
    die("Accès refusé");
}

// On récupère les données envoyées par le Penguin
$json_recu = file_get_contents('php://input');

if ($json_recu) {
    // On l'enregistre dans data_cache.json
    // PHP créera le fichier automatiquement s'il n'existe pas
    if (file_put_contents('data_cache.json', $json_recu)) {
        echo "Synchronisation réussie !";
    } else {
        http_response_code(500);
        echo "Erreur d'écriture sur le serveur Azure.";
    }
} else {
    echo "Aucune donnée reçue.";
}