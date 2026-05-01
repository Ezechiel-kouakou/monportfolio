<?php
header("Content-Type: text/plain; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo "=== DIAGNOSTIC RÉSEAU AZURE ===\n";
echo "Date : " . date('Y-m-d H:i:s') . "\n";
echo "Utilisateur PHP : " . trim(shell_exec('whoami') ?: 'Inconnu') . "\n";
echo "Interface Tailscale : " . (shell_exec('ip addr show tailscale0') ? "OUI" : "NON TROUVÉE") . "\n";

// Liste des cibles à tester
$targets = [
    "LOCAL_APACHE"    => "http://127.0.0.1/video-local/",
    "PENGUIN_DIRECT"  => "http://100.65.154.19:8082/",
    "PENGUIN_DNS"     => "http://penguin.tailc4a1d9.ts.net:8082/"
];

function test_url($name, $url) {
    echo "\n--- TEST : $name ---\n";
    echo "URL : $url\n";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    // On ajoute le Host pour le test local
    if ($name === "LOCAL_APACHE") {
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Host: serverazure.tailc4a1d9.ts.net"]);
    }

    $res = curl_exec($ch);
    $info = curl_getinfo($ch);
    $err = curl_error($ch);
    curl_close($ch);

    echo "Résultat : " . ($err ? "ÉCHEC" : "SUCCÈS") . "\n";
    if ($err) echo "Erreur cURL : $err\n";
    echo "Code HTTP : " . $info['http_code'] . "\n";
    
    // Si succès, on check si c'est bien une vidéo ou un index
    if (!$err && $info['http_code'] == 200) {
        echo "Type contenu : " . $info['content_type'] . "\n";
        if (str_contains($info['content_type'], 'text/html')) {
            echo "⚠️ ATTENTION : Reçoit du HTML au lieu d'un flux vidéo.\n";
        }
    }
}

foreach ($targets as $name => $url) {
    test_url($name, $url);
}

echo "\n=== FIN DU DIAGNOSTIC ===\n";