<?php
// Script de mise à jour sécurisé par un token
$token_attendu = "ezechiel_secure_token_2024"; // Changez ce token et gardez-le secret
if ($_GET['token'] !== $token_attendu) die("Interdit");

$donnees = file_get_contents('php://input');
if ($donnees) {
    file_put_contents('data_cache.json', $donnees);
    echo "OK";
}