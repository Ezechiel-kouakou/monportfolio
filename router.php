<?php
$path = ltrim($_SERVER["REQUEST_URI"], '/');

// 1. AUTORISER L'EXÉCUTION DES FICHIERS PHP
if ($path === 'traitment.php' || $path === 'debug.php') {
    return false; // Permet au serveur PHP d'exécuter ces fichiers
}

// 2. GÉRER LES FICHIERS STATIQUES DU DOSSIER DIST
if (file_exists("dist/$path") && is_file("dist/$path")) {
    $mimes = [
        'js' => 'application/javascript', 
        'css' => 'text/css', 
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg'
    ];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (isset($mimes[$ext])) {
        header("Content-Type: " . $mimes[$ext]);
    }
    readfile("dist/$path");
    exit;
}

// 3. PAR DÉFAUT : SERVIR LE PORTFOLIO
readfile("dist/index.html");
?>