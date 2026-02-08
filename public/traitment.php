<?php
require_once 'config.php';

header('Content-Type: application/json');

// Vérification de la méthode
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit;
}

// Réception des données de Vue.js
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue"]);
    exit;
}

// Nettoyage des données pour correspondre à tes colonnes Supabase
$nom = nettoyer($data['nom'] ?? '');
$prenom = nettoyer($data['prenom'] ?? ''); // Ajouté
$email = nettoyer($data['email'] ?? '');
$role = nettoyer($data['role'] ?? 'Non spécifié'); // Ajouté
$entreprise = nettoyer($data['entreprise'] ?? 'Non spécifié'); // Ajouté
$message = nettoyer($data['message'] ?? '');

try {
    // Requête SQL basée sur ton image db.png
    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
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
        "message" => "Erreur base de données",
        "debug" => $e->getMessage() // Te dira si une colonne manque
    ]);
}
exit;