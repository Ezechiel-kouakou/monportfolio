<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

$ip_penguin = "100.65.154.19";
// ON UTILISE LE PORT 8082 ICI
$source_url = "http://" . $ip_penguin . ":8082/" . $file; 

$context = stream_context_create([
    "http" => [
        "header" => "Host: penguin.tailc4a1d9.ts.net\r\n", 
        "timeout" => 20
    ]
]);

$stream = @fopen($source_url, 'rb', false, $context);

if ($stream) {
    if (ob_get_level()) ob_end_clean();
    header("Content-Type: video/mp4");
    fpassthru($stream);
    fclose($stream);
} else {
    header("Content-Type: text/plain; charset=UTF-8");
    $err = error_get_last();
    echo "Impossible de joindre Penguin sur le port 8082.\n";
    echo "Erreur : " . ($err['message'] ?? "Vérifiez que le conteneur a bien démarré.");
}