<?php
// On force l'affichage de tout pour le diagnostic
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🛠️ Diagnostic Global Portfolio</h1>";

// 1. CHARGEMENT DES VARIABLES (Comme dans ton config.php)
echo "<h3>1. Test des Variables d'Environnement</h3>";
$host = getenv('DB_HOST') ?: 'Non défini';
$dbname = getenv('DB_NAME') ?: 'Non défini';
echo "Host détecté : " . $host . "<br>";
echo "Base détectée : " . $dbname . "<br>";

// 2. TEST DE CONNEXION (Format PostgreSQL comme ton config.php)
echo "<h3>2. Tentative de Connexion PDO (PostgreSQL)</h3>";
try {
    $dsn = "pgsql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";sslmode=require";
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✅ CONNEXION RÉUSSIE à la base de données !<br>";
} catch (PDOException $e) {
    echo "❌ ÉCHEC DE CONNEXION : " . $e->getMessage() . "<br>";
    exit("Arrêt du test.");
}

// 3. VÉRIFICATION DE LA TABLE 'contacts'
echo "<h3>3. Vérification de la Table 'contacts'</h3>";
try {
    $query = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'contacts'");
    $columns = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($columns) > 0) {
        echo "✅ La table 'contacts' existe. Structure détectée :<br><ul>";
        foreach ($columns as $col) {
            echo "<li>" . $col['column_name'] . " (" . $col['data_type'] . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "❌ La table 'contacts' est introuvable.<br>";
        echo "<strong>Crée-la avec ce SQL :</strong><br>";
        echo "<pre>CREATE TABLE contacts (
    id SERIAL PRIMARY KEY,
    role VARCHAR(100),
    entreprise VARCHAR(100),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</pre>";
    }
} catch (Exception $e) {
    echo "❌ Erreur lors de la lecture de la table : " . $e->getMessage();
}

// 4. TEST D'INSERTION RÉEL (Simulé)
echo "<h3>4. Test d'Insertion (Données fictives)</h3>";
try {
    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':role' => 'Test Debug',
        ':entreprise' => 'Railway Inc',
        ':nom' => 'KOUAKOU',
        ':prenom' => 'Ezechiel',
        ':email' => 'test@debug.com',
        ':message' => 'Ceci est un test automatique via debug.php'
    ]);
    echo "✅ INSERTION RÉUSSIE ! Un message de test a été ajouté.<br>";
} catch (PDOException $e) {
    echo "❌ ÉCHEC DE L'INSERTION : " . $e->getMessage() . "<br>";
}

echo "<br><hr><p>Si tout est au vert (✅), ton problème vient uniquement de l'URL appelée par ton front-end (Vue.js).</p>";
?>