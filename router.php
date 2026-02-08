<?php
$path = ltrim($_SERVER["REQUEST_URI"], '/');

// 1. SI C'EST TON FORMULAIRE (on laisse PHP l'exécuter)
if ($path === 'traitment.php') {
    return false; // Dit au serveur : "Exécute ce fichier normalement"
}

// 2. SI C'EST UN FICHIER EXISTANT (JS, CSS, PDF)
if (file_exists("dist/$path") && is_file("dist/$path")) {
    $mimes = [
        'js' => 'application/javascript', 
        'css' => 'text/css', 
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf'
    ];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (isset($mimes[$ext])) {
        header("Content-Type: " . $mimes[$ext]);
    }
    readfile("dist/$path");
    exit;
}

// 3. PAR DÉFAUT : ON AFFICHE LE PORTFOLIO
readfile("dist/index.html");
?>