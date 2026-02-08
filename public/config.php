<?php
session_start();

// On active l'affichage pour le debug, mais on log tout dans un fichier
ini_set('display_errors', 1); 
error_reporting(E_ALL);

// Log de diagnostic au début du script
$debug_log = [];

if(file_exists(__DIR__.'/.env')){
    $lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
        if(strpos(trim($line),'#') === 0){continue;}
        if(strpos($line,'=') !== false){
            list($name, $value) = explode('=', $line, 2);
            putenv(sprintf('%s=%s', trim($name), trim($value)));
        }
    }
    $debug_log[] = ".env chargé localement";
}

// Vérification des variables (on masque le mot de passe dans les logs)
$host = getenv('DB_HOST');
if (!$host) {
    // Si getenv échoue, on tente de récupérer les variables globales de Railway
    $host = $_ENV['DB_HOST'] ?? null;
}

define('DB_HOST', $host);
define('DB_PORT', getenv('DB_PORT') ?: '6543');
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

try {
    if (!DB_HOST) throw new Exception("DB_HOST est vide. Vérifiez vos variables Railway.");

    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";sslmode=require";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false, 
        "debug_error" => "Erreur Connexion: " . $e->getMessage(),
        "env_check" => [
            "host_found" => !empty(DB_HOST),
            "user_found" => !empty(DB_USER)
        ]
    ]);
    exit;
}

if (!function_exists('nettoyer')) {
    function nettoyer($data) {
        return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}
?>