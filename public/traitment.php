<?php
session_start();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); 

// On affiche les erreurs pour le debug, mais on capture tout en JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    // --- 1. CONFIGURATION CONNEXION DIRECTE ---
    // Remplace ici par tes vrais identifiants si nécessaire
    $host = 'localhost';
    $dbname = 'portfeuil'; 
    $user = 'root';
    $pass = ''; // Vide par défaut sur WAMP

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        throw new Exception("Connexion BDD échouée : " . $e->getMessage());
    }

    // --- 2. VÉRIFICATION MÉTHODE ---
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode " . $_SERVER['REQUEST_METHOD'] . " non autorisée.");
    }

    // --- 3. NETTOYAGE ET RÉCUPÉRATION ---
    function nettoyer($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $role       = nettoyer($_POST['role'] ?? 'particulier');
    $entreprise = nettoyer($_POST['entreprise'] ?? '');
    $nom        = nettoyer($_POST['nom'] ?? '');
    $prenom     = nettoyer($_POST['prenom'] ?? '');
    $email      = nettoyer($_POST['email'] ?? '');
    $message    = nettoyer($_POST['message'] ?? '');

    // --- 4. LOG DE DEBUG (Vérifier ce que le PHP reçoit) ---
    // Si tu as une erreur, on verra ce que le PHP a "lu"
    if (empty($nom) || empty($email)) {
        throw new Exception("Données manquantes (Nom ou Email vide). Reçu : Nom=$nom, Email=$email");
    }

    // --- 5. INSERTION ---
    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':role'       => $role,
        ':entreprise' => $entreprise,
        ':nom'        => $nom,
        ':prenom'     => $prenom,
        ':email'      => $email,
        ':message'    => $message
    ]);

    echo json_encode([
        "success" => true, 
        "message" => "Succès ! Données insérées pour $prenom $nom."
    ]);

} catch (Exception $e) {
    // --- 6. RÉPONSE EN CAS D'ERREUR ---
    http_response_code(500);
    echo json_encode([
        "success" => false, 
        "message" => "Détail de l'erreur : " . $e->getMessage(),
        "file"    => $e->getFile(),
        "line"    => $e->getLine()
    ]);
}