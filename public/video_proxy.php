<?php
$file = $_GET['file'] ?? '';
$source_url = "http://penguin.tailc4a1d9.ts.net/" . $file; // Test en HTTP

// On essaie d'ouvrir le fichier
$stream = @fopen($source_url, 'rb');

if (!$stream) {
    // Si ça échoue, on affiche l'erreur système pour comprendre pourquoi
    $last_error = error_get_last();
    header("Content-Type: text/plain");
    echo "ERREUR DE CONNEXION : \n";
    echo "Cible : " . $source_url . "\n";
    echo "Message : " . $last_error['message'];
    exit;
}

header('Content-Type: video/mp4');
fpassthru($stream);