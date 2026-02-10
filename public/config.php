<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host   = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$port   = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '6543';
$user   = $_ENV['DB_USER'] ?? getenv('DB_USER');
$pass   = $_ENV['DB_PASS'] ?? getenv('DB_PASS');
$dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

try {
    if (!$host) {
        throw new Exception("Variables d'environnement introuvables. Vérifiez le dashboard Railway.");
    }
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5
    ]);

} catch (Exception $e) {
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