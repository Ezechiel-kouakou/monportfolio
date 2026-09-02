<?php
/**
 * api_chatbot.php
 * ------------------------------------------------------------------
 * Pont entre le widget de chat (Vue) et le micro-service FastAPI de
 * recommandation par similarité sémantique.
 *
 * Le visiteur (navigateur) ne parle JAMAIS directement à FastAPI ni ne
 * connaît la clé API : tout transite par ce script, comme pour
 * api_comments.php et api_proxy.php.
 *
 * Déploiement : Azure App Service (conteneur, FrankenPHP), base PostgreSQL
 * (Supabase). Les identifiants DB (DB_HOST, DB_PORT, DB_USER, DB_PASS,
 * DB_NAME) sont les mêmes variables déjà visibles dans "Paramètres de
 * l'application" côté Azure, utilisées par config.php — aucune nouvelle
 * variable de base de données à créer.
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// --- CORS -----------------------------------------------------------------
$allowed_origins = [
    'https://www.ezechielkouakou.fr',
    'https://ezechielkouakou.fr',
    'http://localhost:5173', // dev local (Vite)
];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowed_origins, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
    exit;
}

// --- Configuration -----------------------------------------------------
//
// Azure App Service expose les variables (définies dans "Paramètres de
// l'application") via $_ENV ou getenv() (même pattern que dans config.php).
// CHATBOT_FASTAPI_URL et CHATBOT_API_KEY sont spécifiques au chatbot ; les
// variables DB_* sont RÉUTILISÉES telles quelles depuis ce qui existe déjà
// pour config.php.

function readEnv(string $key): ?string
{
    $value = $_ENV[$key] ?? getenv($key);
    return ($value !== false && $value !== '') ? $value : null;
}

$fastApiUrl = readEnv('CHATBOT_FASTAPI_URL');
$apiKey     = readEnv('CHATBOT_API_KEY');

// Seules l'URL FastAPI et la clé API sont indispensables au fonctionnement
// du chatbot lui-même.
if (!$apiKey || !$fastApiUrl) {
    http_response_code(500);
    error_log('[api_chatbot] Configuration incomplète : CHATBOT_FASTAPI_URL ou CHATBOT_API_KEY manquant sur Railway.');
    echo json_encode(['success' => false, 'error' => 'Configuration serveur manquante.']);
    exit;
}

define('CHATBOT_FASTAPI_URL', $fastApiUrl);
define('CHATBOT_API_KEY', $apiKey);

// Identifiants DB : réutilisation des variables déjà présentes sur Railway
// pour config.php. Optionnelles ici : si absentes, le chatbot répond quand
// même, il ne loggue simplement rien.
$dbHost = readEnv('DB_HOST');
$dbPort = readEnv('DB_PORT') ?? '6543';
$dbUser = readEnv('DB_USER');
$dbPass = readEnv('DB_PASS');
$dbName = readEnv('DB_NAME');
$dbLoggingEnabled = $dbHost && $dbUser && $dbPass && $dbName;

// --- Lecture et validation de l'entrée -------------------------------------

$rawBody = file_get_contents('php://input');
$payload = json_decode($rawBody, true);

if (!is_array($payload) || empty(trim($payload['message'] ?? ''))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Champ "message" manquant ou vide.']);
    exit;
}

$message = trim($payload['message']);

// Garde-fou basique contre les messages absurdement longs (abus / spam)
if (mb_strlen($message) > 500) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Message trop long (500 caractères max).']);
    exit;
}

// --- Appel au service FastAPI ----------------------------------------------

function callFastApi(string $message): array
{
    $ch = curl_init(CHATBOT_FASTAPI_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-API-Key: ' . CHATBOT_API_KEY,
        ],
        CURLOPT_POSTFIELDS => json_encode(['message' => $message]),
        CURLOPT_TIMEOUT => 8, // le modèle répond en général en quelques centaines de ms
        CURLOPT_CONNECTTIMEOUT => 3,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        error_log('[api_chatbot] Erreur cURL vers FastAPI : ' . $curlError);
        return ['ok' => false, 'data' => null];
    }

    $data = json_decode($response, true);
    if ($httpCode !== 200 || !is_array($data)) {
        error_log('[api_chatbot] Réponse FastAPI invalide (HTTP ' . $httpCode . ') : ' . $response);
        return ['ok' => false, 'data' => null];
    }

    return ['ok' => true, 'data' => $data];
}

$result = callFastApi($message);

if (!$result['ok']) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'answer' => "Petit souci technique avec l'assistant, réessaie dans un instant.",
        'suggestions' => [],
    ]);
    exit;
}

$fastApiData = $result['data'];

// --- Log en base (optionnel, PostgreSQL/Supabase) ---------------------------
//
// Volontairement une connexion PDO SÉPARÉE de celle de config.php : ce
// dernier appelle exit() si la connexion échoue, ce qui casserait tout le
// chatbot en cas de souci DB. Le log doit rester non bloquant.

if ($dbLoggingEnabled) {
    try {
        $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName};sslmode=require";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);

        // On ne stocke jamais l'IP en clair : un hash suffit pour un futur
        // rate-limiting éventuel, sans conserver de donnée personnelle directe.
        $ipHash = hash('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown');

        $stmt = $pdo->prepare(
            'INSERT INTO chatbot_logs
                (question_visiteur, question_matchee, reponse_donnee, score, reussite, ip_hash)
             VALUES (:question, :matchee, :reponse, :score, :reussite, :ip_hash)'
        );
        $stmt->execute([
            ':question' => $message,
            ':matchee'  => $fastApiData['matched_question'] ?? null,
            ':reponse'  => $fastApiData['answer'] ?? null,
            ':score'    => $fastApiData['score'] ?? null,
            ':reussite' => !empty($fastApiData['success']) ? 1 : 0,
            ':ip_hash'  => $ipHash,
        ]);
    } catch (Throwable $e) {
        error_log('[api_chatbot] Échec du log en base (non bloquant) : ' . $e->getMessage());
    }
}

// --- Réponse au widget -------------------------------------------------------

echo json_encode([
    'success' => (bool) ($fastApiData['success'] ?? false),
    'answer' => $fastApiData['answer'] ?? "Je n'ai pas trouvé de réponse précise à cette question.",
    'suggestions' => $fastApiData['suggestions'] ?? [],
]);