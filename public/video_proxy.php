<?php
/* --- CONFIGURATION DES ENTÊTES --- */
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Access-Control-Allow-Methods: GET");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

// 1. Paramètres de ton infrastructure
$ip_penguin = "100.65.154.19";
$host_dns = "penguin.tailc4a1d9.ts.net";

// 2. On passe en HTTP (port 80) pour éviter le refus de connexion SSL
$source_url = "http://" . $ip_penguin . "/" . $file;

// 3. On garde le header Host pour que OpenResty sache quel dossier (/www) ouvrir
$context = stream_context_create([
    "http" => [
        "header" => "Host: " . $host_dns . "\r\n", 
        "timeout" => 20,
        "follow_location" => 1
    ]
]);

// 4. Tentative d'ouverture
$stream = @fopen($source_url, 'rb', false, $context);

if ($stream) {
    // Si succès, on nettoie les buffers et on envoie la vidéo
    if (ob_get_level()) ob_end_clean();
    
    header("Content-Type: video/mp4");
    // Optionnel : Récupération de la taille pour la barre de lecture
    $headers = get_headers($source_url, 1, $context);
    if (isset($headers['Content-Length'])) {
        header("Content-Length: " . $headers['Content-Length']);
    }

    fpassthru($stream);
    fclose($stream);
} else {
    header("Content-Type: text/plain; charset=UTF-8");
    $last_error = error_get_last();
    echo "--- ÉCHEC FINAL DU PONT ---\n";
    echo "Tentative sur : " . $source_url . "\n";
    echo "Erreur : " . ($last_error['message'] ?? "Le serveur Penguin ne répond pas sur le port 80.");
    echo "\n\nNote : Vérifie que ton conteneur Docker sur Penguin expose bien le port 80.";
}