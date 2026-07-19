<?php
// =========================================================================
// CONFIGURATION DES EN-TÊTES CORS
// =========================================================================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// =========================================================================
// FONCTION POUR CHARGER LE FICHIER .ENV
// =========================================================================
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        $value = trim($value, '"\'');

        if (!getenv($name)) {
            putenv("{$name}={$value}");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
    return true;
}

// MODIFICATION ICI : On remonte d'un niveau (/../) pour atteindre la racine absolue
loadEnv(__DIR__ . '/../.env');

// =========================================================================
// RÉCUPÉRATION DES VARIABLES VIA GETENV()
// =========================================================================
$supabaseUrl = getenv('SUPABASE_URL');
$supabaseKey = getenv('SUPABASE_KEY');

if (!$supabaseUrl || !$supabaseKey) {
    echo json_encode([
        "success" => false, 
        "error" => "Erreur de configuration : Impossible de lire les cles Supabase depuis le .env racine."
    ]);
    exit;
}

define('SUPABASE_URL', $supabaseUrl);
define('SUPABASE_KEY', $supabaseKey); 

$method = $_SERVER['REQUEST_METHOD'];

// =========================================================================
// 1. RÉCUPÉRATION DES COMMENTAIRES (GET)
// =========================================================================
if ($method === 'GET') {
    if (!isset($_GET['video_id'])) {
        echo json_encode(["success" => false, "error" => "Le parametre video_id est manquant."]);
        exit;
    }

    $videoId = urlencode($_GET['video_id']);
    $url = SUPABASE_URL . "/rest/v1/comments?video_id=eq." . $videoId . "&order=date_creation.asc";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $allComments = json_decode($response, true);
        
        $roots = [];
        $replies = [];

        foreach ($allComments as $comment) {
            if (empty($comment['parent_id'])) {
                $comment['replies'] = [];
                $roots[$comment['id']] = $comment;
            } else {
                $replies[] = $comment;
            }
        }

        foreach ($replies as $reply) {
            $parentId = $reply['parent_id'];
            if (isset($roots[$parentId])) {
                $roots[$parentId]['replies'][] = $reply;
            }
        }

        echo json_encode([
            "success" => true,
            "comments" => array_values($roots)
        ]);
    } else {
        echo json_encode([
            "success" => false, 
            "error" => "Erreur lors de la recuperation depuis Supabase."
        ]);
    }
    exit;
}

// =========================================================================
// 2. ENVOI / INSERTION D'UN COMMENTAIRE (POST)
// =========================================================================
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['video_id']) || empty($input['pseudo']) || empty($input['contenu'])) {
        echo json_encode(["success" => false, "error" => "Champs obligatoires manquants."]);
        exit;
    }

    $payload = [
        "video_id"  => $input['video_id'],
        "pseudo"    => $input['pseudo'],
        "contenu"   => $input['contenu'],
        "parent_id" => !empty($input['parent_id']) ? intval($input['parent_id']) : null
    ];

    $url = SUPABASE_URL . "/rest/v1/comments";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY,
        "Content-Type: application/json",
        "Prefer: return=representation"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        echo json_encode([
            "success" => true, 
            "message" => "Commentaire ajoute avec succes.",
            "data" => json_decode($response, true)
        ]);
    } else {
        echo json_encode([
            "success" => false, 
            "error" => "Echec de l'insertion dans Postgres Supabase."
        ]);
    }
    exit;
}

echo json_encode(["success" => false, "error" => "Methode non autorisee."]);