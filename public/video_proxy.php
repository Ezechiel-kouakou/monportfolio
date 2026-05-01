<?php
// Autoriser l'accès depuis ton portfolio
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) {
    header("Content-Type: text/plain");
    die("Erreur : Aucun fichier spécifié dans l'URL.");
}

// L'URL que ton serveur Azure doit contacter en interne
$target = "http://127.0.0.1/video-local/" . $file;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 0); // Indispensable pour les longues vidéos

// CRUCIAL : On passe le Host que ton Apache attend pour le VirtualHost
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: serverazure.tailc4a1d9.ts.net"
]);

// On ne veut pas que cURL affiche les headers directement
curl_setopt($ch, CURLOPT_HEADER, false);
// On veut pouvoir intercepter la sortie
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); 

// Gestion des headers pour le navigateur (seulement si c'est un succès)
curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header) {
    $lower = strtolower($header);
    // On ne transmet les headers vidéo que si c'est un code 200 ou 206
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($code >= 200 && $code < 300) {
        if (str_starts_with($lower, 'content-type:') || 
            str_starts_with($lower, 'content-length:') || 
            str_starts_with($lower, 'accept-ranges:')) {
            header(trim($header));
        }
    }
    return strlen($header);
});

// Support du Range (Scrubbing)
if (isset($_SERVER['HTTP_RANGE'])) {
    curl_setopt($ch, CURLOPT_RANGE, str_replace('bytes=', '', $_SERVER['HTTP_RANGE']));
}

// --- EXÉCUTION ---
// On commence à capturer le tampon pour éviter d'envoyer des données si erreur
ob_start();

$ok = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);

if (!$ok || $http_code >= 400) {
    // Nettoyer tout ce qui a pu être envoyé (octets de vidéo corrompus)
    ob_end_clean();
    
    // Forcer l'affichage en TEXTE pour que tu puisses lire l'erreur
    header("Content-Type: text/plain; charset=UTF-8");
    http_response_code($http_code ?: 502);
    
    echo "=== ERREUR DE PROXY VIDÉO ===\n";
    echo "Cible : " . $target . "\n";
    echo "Code HTTP : " . $http_code . "\n";
    if ($curl_error) echo "Erreur cURL : " . $curl_error . "\n";
    
    echo "\n--- DIAGNOSTIC ---\n";
    if ($http_code == 404) {
        echo "Le dossier '/video-local/' n'est pas trouvé par Apache.\n";
        echo "Vérifie ton fichier /etc/apache2/sites-enabled/000-default.conf";
    } elseif ($http_code == 403) {
        echo "Permissions refusées. L'utilisateur www-data ne peut pas lire le dossier.";
    }
} else {
    // Tout est OK, on vide le tampon (envoie la vidéo)
    ob_end_flush();
}

curl_close($ch);