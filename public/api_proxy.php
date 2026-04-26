<?php
// On autorise ton front-end
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");
header("Content-Type: application/json; charset=UTF-8");

// L'URL exacte qui a fonctionné dans ton curl Azure
$remote_url = 'https://penguin.tailc4a1d9.ts.net/api/get_data.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// CRUCIAL : Comme c'est un réseau privé Tailscale, on ignore la vérification SSL 
// pour éviter les erreurs de certificat auto-signé
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo json_encode([
        "success" => false,
        "message" => "Erreur Proxy : " . $error_msg
    ]);
} else {
    // On renvoie la réponse du Penguin
    echo $response;
}

curl_close($ch);