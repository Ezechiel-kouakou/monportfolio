<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'config.php';

$allowedOrigin = $_ENV['ALLOWED_ORIGIN'] ?? '*';
header("Access-Control-Allow-Origin: $allowedOrigin");
header("Access-Control-Allow-Headers: Content-Type");
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
    echo json_encode(["success" => false, "message" => "Données invalides"]);
    exit;
}

$nom = nettoyer($data['lastname'] ?? '');
$prenom = nettoyer($data['firstname'] ?? ''); 
$email = nettoyer($data['email'] ?? '');
$role = nettoyer($data['role'] ?? 'Non spécifié'); 
$entreprise = nettoyer($data['entreprise'] ?? 'Non spécifié'); 
$message = nettoyer($data['message'] ?? '');

try {
    $sql = "INSERT INTO contacts (role, entreprise, nom, prenom, email, message, created_at) 
            VALUES (:role, :entreprise, :nom, :prenom, :email, :message, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':role' => $role, ':entreprise' => $entreprise,
        ':nom' => $nom, ':prenom' => $prenom,
        ':email' => $email, ':message' => $message
    ]);

    $mail = new PHPMailer(true);
    $mailStatus = "";

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kouakouezechielk06@gmail.com'; 
        $mail->Password   = $_ENV['SMTP_PASS'] ?? ''; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            $mail->SMTPOptions = [
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
            ];
        }

        $mail->setFrom('noreply@ezechielkouakou.fr', 'Portfolio Contact');
        $mail->addAddress('kouakouezechielk06@gmail.com'); 

        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de $prenom $nom";

        $mail->Body = "
        <div style='font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; border-radius: 12px; overflow: hidden;'>
            <div style='background: #000; color: #fff; padding: 30px; text-align: center;'>
                <h1 style='margin: 0; font-size: 20px; letter-spacing: 2px;'>NOUVEAU MESSAGE</h1>
            </div>
            <div style='padding: 30px; color: #333; line-height: 1.6;'>
                <p><strong>Client :</strong> $prenom $nom</p>
                <p><strong>Rôle :</strong> $role " . ($entreprise !== 'Non spécifié' ? "chez <b>$entreprise</b>" : "") . "</p>
                <p><strong>Email :</strong> <a href='mailto:$email' style='color: #22c55e;'>$email</a></p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='color: #666; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;'>Message :</p>
                <div style='background: #f9f9f9; padding: 20px; border-radius: 8px; border-left: 4px solid #000;'>
                    $message
                </div>
            </div>
            <div style='background: #f4f4f4; padding: 15px; text-align: center; font-size: 11px; color: #999;'>
                Ceci est une notification automatique de votre portfolio.
            </div>
        </div>";

        $mail->send();
        $mailStatus = "Email envoyé";
    } catch (Exception $e) {
        $mailStatus = "Erreur mail";
    }

    echo json_encode(["success" => true, "mail_log" => $mailStatus]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur"]);
}