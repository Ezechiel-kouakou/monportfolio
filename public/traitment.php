<?php
/**
 * TRAITEMENT DU FORMULAIRE - VERSION DOCKER/RAILWAY
 */

// 1. On empêche tout texte parasite de sortir avant le JSON
ob_start();

// 2. Headers de sécurité et CORS
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');

// 3. Inclusion de la config (PDO est déjà dedans)
try {
    require_once __DIR__ . '/config.php';
} catch (Exception $e) {
    ob_clean();
    echo json_encode(["success" => false, "message" => "Erreur configuration serveur"]);
    exit;
}

// 4. Récupération des données JSON envoyées par Vue
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
    
    $role = nettoyer($data['role'] ?? '');
    $entreprise = nettoyer($data['entreprise'] ?? '');
    $nom = nettoyer($data['lastname'] ?? '');
    $prenom = nettoyer($data['firstname'] ?? '');
    $email = nettoyer($data['email'] ?? '');
    $message = nettoyer($data['message'] ?? '');

    try {
        // Insertion en Base de données (PostgreSQL)
        $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, date_envoi) 
                VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':role' => $role,
            ':entreprise' => $entreprise,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':message' => $message
        ]);

        // Si tout est OK
        ob_clean(); // On vide le tampon pour être sûr d'avoir un JSON propre
        echo json_encode(["success" => true, "message" => "Message envoyé avec succès"]);

    } catch (PDOException $e) {
        ob_clean();
        echo json_encode(["success" => false, "message" => "Erreur DB : " . $e->getMessage()]);
    }
} else {
    ob_clean();
    echo json_encode(["success" => false, "message" => "Requête invalide"]);
}
exit;

