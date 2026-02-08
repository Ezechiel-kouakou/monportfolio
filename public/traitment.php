<?php
// On inclut config.php qui contient déjà l'activation des erreurs
require_once 'config.php';

header('Content-Type: application/json');

// Activation locale des erreurs au cas où config.php soit écrasé
ini_set('display_errors', 1);
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

// Extraction et nettoyage des données
$nom = nettoyer($data['nom'] ?? '');
$prenom = nettoyer($data['prenom'] ?? ''); 
$email = nettoyer($data['email'] ?? '');
$role = nettoyer($data['role'] ?? 'Non spécifié'); 
$entreprise = nettoyer($data['entreprise'] ?? 'Non spécifié'); 
$message = nettoyer($data['message'] ?? ''); // Correction : Ajout de la variable message manquante

try {
    // On s'assure que la table et les colonnes correspondent à PostgreSQL
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
    // Renvoie l'erreur SQL précise (ex: table manquante ou colonne mal nommée)
    echo json_encode([
        "success" => false, 
        "message" => "Erreur base de données technique",
        "debug" => $e->getMessage() 
    ]);
}
exit;