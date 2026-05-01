<?php
// Test 1 : curl est-il dispo ?
echo "curl installé : " . (function_exists('curl_init') ? "OUI" : "NON") . "\n";

// Test 2 : depuis quel utilisateur tourne PHP ?
echo "Utilisateur PHP : " . shell_exec('whoami') . "\n";

// Test 3 : peut-il atteindre l'IP Tailscale ?
$ch = curl_init("http://100.65.154.19:8082/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$result = curl_exec($ch);
echo "Erreur curl : " . curl_error($ch) . "\n";
echo "HTTP code : " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
curl_close($ch);