<?php
/* --- CONFIGURATION DES ENTÊTES (Identique à ton API) --- */
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: video/mp4"); // On change juste le type de contenu
header("Access-Control-Allow-Methods: GET");

/* --- SÉCURITÉ REFERER (Identique à ton API) --- */
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (empty($referer) || strpos($referer, 'ezechielkouakou.fr') === false) {
    http_response_code(403);
    echo "Accès direct interdit. Ce flux est réservé au portfolio.";
    exit;
}

/* --- LOGIQUE RÉSEAU (Adaptée pour le streaming) --- */
$file_param = $_GET['file'] ?? '';
$file = basename($file_param); 

if (empty($file)) {
    http_response_code(400);
    die("Fichier manquant.");
}

// C'est ici que la différence se joue : au lieu de file_exists(cache), 
// on vérifie si Penguin répond via Tailscale
$source_url = "http://100.65.154.19/" . $file; 

// On tente d'ouvrir le flux vers Penguin
$stream = @fopen($source_url, 'rb');

if ($stream) {
    // Si la connexion réussit, on "echo" le contenu (comme ton API fait echo $data)
    // Mais on utilise fpassthru car une vidéo est trop lourde pour un simple echo
    fpassthru($stream);
    fclose($stream);
} else {
    // Si Penguin est éteint ou Tailscale coupé (Equivalent de ton 404 cache)
    http_response_code(404);
    echo "Source vidéo non disponible (Vérifiez le serveur Penguin).";
}
?>