<?php
require_once 'config.php';

header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue ou JSON invalide"]);
    exit;
}
$nom = nettoyer($data['nom'] ?? '');
$prenom = nettoyer($data['prenom'] ?? ''); 
$email = nettoyer($data['email'] ?? '');
$role = nettoyer($data['role'] ?? 'Non spécifié'); 
$entreprise = nettoyer($data['entreprise'] ?? 'Non spécifié'); 
$message = nettoyer($data['message'] ?? '');
try {

    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':role' => $role,
        ':entreprise' => $entreprise,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':message' => $message
    ]);

    echo json_encode([
        "success" => true, 
        "message" => "Merci $prenom, votre message a été enregistré !"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false, 
        "message" => "Erreur base de données technique",
        "debug" => $e->getMessage() 
    ]);
}
exit;