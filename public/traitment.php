<?php
require_once __DIR__ . '/phpmailer/Exception.php';
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ob_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/config.php';
} catch (Exception $e) {
    ob_clean();
    echo json_encode(["success" => false, "message" => "Erreur configuration serveur"]);
    exit;
}

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
        if ($result) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = getenv('SMTP_HOST'); 
                $mail->SMTPAuth   = true;
                $mail->Username   = getenv('SMTP_USER'); 
                $mail->Password   = getenv('SMTP_PASS'); 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom(getenv('SMTP_USER'), 'Portfolio Contact');
                $mail->addAddress(getenv('SMTP_USER')); 
                $mail->addReplyTo($email, "$prenom $nom");

                $mail->isHTML(true);
                $mail->Subject = "Nouveau message de $prenom $nom";
                $mail->Body    = "<b>Nom :</b> $prenom $nom <br>
                                  <b>Entreprise :</b> $entreprise <br>
                                  <b>Rôle :</b> $role <br>
                                  <b>Email :</b> $email <br><br>
                                  <b>Message :</b><br>$message";

                $mail->send();
            } catch (Exception $e) {
                ob_clean();
                echo json_encode(["success" => false, "message" => "Erreur d'envoi du mail : " . $mail->ErrorInfo]);
            }
        }

        ob_clean();
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