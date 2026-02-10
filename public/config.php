<?php
$is_local = ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1');
error_reporting(E_ALL);
ini_set('display_errors', $is_local ? 1 : 0);

$env_path = __DIR__ . '/../.env';

if (file_exists($env_path)) {
    $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $name = trim($parts[0]);
            $value = trim($parts[1]);
            
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}
$host   = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$port   = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '6543';
$user   = $_ENV['DB_USER'] ?? getenv('DB_USER');
$pass   = $_ENV['DB_PASS'] ?? getenv('DB_PASS');
$dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

$sslmode = $is_local ? "disable" : "require";
try {
    if (!$host) {
        throw new Exception("Fichier .env non détecté ou vide à la racine du projet.");
    }

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode";
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5 
    ]);

} catch (Exception $e) {
    if ($is_local) {
        die("ERREUR DE CONNEXION a la DB: " . $e->getMessage());
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Base de données indisponible"]);
        exit;
    }
}
if (!function_exists('nettoyer')) {
    function nettoyer($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}
?>