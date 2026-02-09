<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
if(file_exists(__DIR__.'/.env')){
    $lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
        if(strpos(trim($line),'#') === 0){continue;}
        if(strpos($line,'=') !== false){
            list($name, $value) = explode('=', $line, 2);
            putenv(sprintf('%s=%s', trim($name), trim($value)));
            $_ENV[trim($name)] = trim($value); 
        }
    }
}
define('DB_HOST', getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? ''));
define('DB_PORT', getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '6543'));
define('DB_USER', getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? ''));
define('DB_PASS', getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? ''));
define('DB_NAME', getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'postgres'));

try {
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";sslmode=require";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false, 
        "message" => "Erreur de connexion : " . $e->getMessage()
    ]);
    exit;
}

if (!function_exists('nettoyer')) {
    function nettoyer($data) {
        return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}
?>