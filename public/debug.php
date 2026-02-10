<?php
// On force l'affichage pour le diagnostic
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CHARGEMENT DU .ENV (Copie de la logique config.php)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            putenv(trim($parts[0]) . "=" . trim($parts[1]));
        }
    }
}

echo "<h1>🛠️ Diagnostic Global Portfolio</h1>";

// 1. TEST DES VARIABLES
echo "<h3>1. Test des Variables d'Environnement</h3>";
$host = getenv('DB_HOST') ?: '❌ Non détecté (Vérifie ton .env)';
$dbname = getenv('DB_NAME') ?: '❌ Non détecté';
echo "Host détecté : " . $host . "<br>";
echo "Base détectée : " . $dbname . "<br>";

// 2. TENTATIVE DE CONNEXION
echo "<h3>2. Tentative de Connexion PDO (PostgreSQL)</h3>";
try {
    $dsn = "pgsql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";sslmode=require";
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✅ CONNEXION RÉUSSIE à Supabase !<br>";
} catch (PDOException $e) {
    echo "❌ ÉCHEC DE CONNEXION : " . $e->getMessage() . "<br>";
    exit("<br><b>Conseil :</b> Vérifie si l'extension 'php_pdo_pgsql' est cochée dans Wamp.");
}

// 3. VÉRIFICATION DE LA TABLE
echo "<h3>3. Vérification de la Table 'contacts'</h3>";
try {
    $query = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'contacts'");
    $columns = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($columns) > 0) {
        echo "✅ La table 'contacts' existe.<br>";
    } else {
        echo "❌ La table 'contacts' est introuvable sur Supabase.<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur table : " . $e->getMessage();
}
?>