<?php
/* --- CONFIGURATION DES ENTÊTES --- */
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Access-Control-Allow-Methods: GET");

$file_param = $_GET['file'] ?? '';
$file = basename($file_param); 

if (empty($file)) {
    header("Content-Type: text/plain");
    die("Erreur : Aucun fichier spécifié dans l'URL.");
}

// URL cible sur Penguin
$source_url = "https://penguin.tailc4a1d9.ts.net/" . $file; 

// On active l'affichage des erreurs PHP pour le débug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// On tente d'ouvrir le flux
$stream = @fopen($source_url, 'rb');

if ($stream) {
    // Si ça marche, on envoie la vidéo
    header("Content-Type: video/mp4");
    fpassthru($stream);
    fclose($stream);
} else {
    // SI ÇA ÉCHOUE : On change le type en TEXTE pour voir l'erreur
    header("Content-Type: text/plain; charset=UTF-8");
    $last_error = error_get_last();
    
    echo "--- DIAGNOSTIC D'ERREUR ---\n";
    echo "Cible : " . $source_url . "\n";
    echo "Le serveur Azure n'a pas pu ouvrir la vidéo.\n";
    echo "Raison possible : " . ($last_error['message'] ?? "Aucun message d'erreur système.");
    echo "\n\nVérifications à faire :\n";
    echo "1. Est-ce que 'serverazure' est BIEN VERT (connecté) dans Tailscale ?\n";
    echo "2. Est-ce que tu peux ping 100.65.154.19 depuis le terminal Azure ?\n";
}
?>