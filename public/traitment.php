<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php'; 

ob_start();
$allowed_origin = getenv('ALLOWED_ORIGIN') ?: '*';
header("Access-Control-Allow-Origin: $allowed_origin");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
    
    $nom = nettoyer($data['lastname'] ?? '');
    $prenom = nettoyer($data['firstname'] ?? '');
    $email = nettoyer($data['email'] ?? '');
    $message = nettoyer($data['message'] ?? '');

    try {
        $sql = "INSERT INTO contacts (nom, prenom, email, message, date_envoi) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $message]);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER');
        $mail->Password   = getenv('SMTP_PASS'); 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(getenv('SMTP_USER'), 'Portfolio Contact');
        $mail->addAddress(getenv('SMTP_USER'));
        $mail->addReplyTo($email, "$prenom $nom");

        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de $prenom $nom";
        $mail->Body    = "<h3>Nouveau message reçu</h3>
                          <p><strong>De:</strong> $prenom $nom ($email)</p>
                          <p><strong>Message:</strong><br>$message</p>";

        $mail->send();

        ob_clean();
        echo json_encode(["success" => true, "message" => "Message envoyé !"]);

    } catch (Exception $e) {
        ob_clean();
        echo json_encode(["success" => false, "message" => "Erreur : " . $mail->ErrorInfo]);
    }
}