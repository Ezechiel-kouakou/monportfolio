<?php
session_start();
header('Content-Type: application/json');

$allowed_origins = [
    "https://www.ezechielkouakou.fr",
    "https://ezechielkouakou.fr"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}


require_once 'config.php';

ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    $limit = 60; 
    if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit'] < $limit)) {
        $wait = $limit - (time() - $_SESSION['last_submit']);
        throw new Exception("Trop de messages. Veuillez patienter $wait secondes.");
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode " . $_SERVER['REQUEST_METHOD'] . " non autorisée.");
    }

    $role       = nettoyer($_POST['role'] ?? 'particulier');
    $entreprise = nettoyer($_POST['entreprise'] ?? '');
    $nom        = nettoyer($_POST['nom'] ?? '');
    $prenom     = nettoyer($_POST['prenom'] ?? '');
    $email      = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message    = nettoyer($_POST['message'] ?? '');

    if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
        throw new Exception("Tous les champs obligatoires ne sont pas remplis.");
    }

    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, CURRENT_TIMESTAMP)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':role'       => $role,
        ':entreprise' => $entreprise,
        ':nom'        => $nom,
        ':prenom'     => $prenom,
        ':email'      => $email,
        ':message'    => $message
    ]);
    $to = "kouakouezechielk06@gmail.com";
    $subject = "Nouveau projet ou contact recruteur : $prenom $nom ($role)";
  
    $email_body = "hello, vous avez reçu un nouveau message depuis votre portfolio.\n\n";
    $email_body .= "---------- Infos nécessaires ----------\n";
    $email_body .= "Type : " . strtoupper($role) . "\n\n";
    if ($role === 'entreprise' && !empty($entreprise)) {
        $email_body .= "Société : $entreprise\n\n";
    }
    $email_body .= "Nom : $prenom $nom\n";
    $email_body .= "Email : $email\n";
    $email_body .= "------------------------------\n\n";
    $email_body .= "Message :\n$message\n\n";
    $email_body .= "------------------------------\n";
    $email_body .= "Envoyé le : " . date('d/m/Y à H:i:s');

    $headers = "From: contact@ezechielkouakou.fr\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    @mail($to, $subject, $email_body, $headers);
    $_SESSION['last_submit'] = time();

    echo json_encode([
        "success" => true, 
        "message" => "Hey 👋 $prenom merci, votre demande a été enregistrée avec succès."
    ]);

} catch (Exception $e) {
    http_response_code(400); 
    echo json_encode([
        "success" => false, 
        "message" => $e->getMessage()
    ]);
}