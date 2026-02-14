<?php
ob_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/config.php';
} catch (Exception $e) {
    ob_clean();
    echo json_encode(["success" => false, "message" => "Erreur configuration"]);
    exit;
}

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
        $result = $stmt->execute([$nom, $prenom, $email, $message]);

        if ($result) {
            $url = 'https://api.brevo.com/v3/smtp/email';
            $apiKey = getenv('BREVO_API_KEY');
            $monEmail = 'kouakouezechiel06@gmail.com'; 

            $emailData = [
                'sender' => [
                    'name' => 'Portfolio Contact', 
                    'email' => $monEmail
                ],
                'to' => [
                    ['email' => $monEmail]
                ],
                'replyTo' => [
                    'email' => $email, 
                    'name' => "$prenom $nom"
                ],
                'subject' => "Nouveau message de $prenom $nom",
                'htmlContent' => "
                    <h3>Nouveau message reçu</h3>
                    <p><strong>De :</strong> $prenom $nom ($email)</p>
                    <p><strong>Message :</strong></p>
                    <p>" . nl2br($message) . "</p>
                "
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'api-key: ' . $apiKey,
                'Content-Type: application/json',
                'Accept: application/json'
            ]);

            $response = curl_exec($ch);
            curl_close($ch);
        }

        ob_clean();
        echo json_encode(["success" => true, "message" => "Message envoyé avec succès"]);

    } catch (PDOException $e) {
        ob_clean();
        echo json_encode(["success" => false, "message" => "Erreur DB : " . $e->getMessage()]);
    }
}
exit;