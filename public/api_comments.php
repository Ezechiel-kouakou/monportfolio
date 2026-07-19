<?php
// =========================================================================
// CONFIGURATION DES EN-TÊTES CORS
// (à faire AVANT d'inclure config.php pour gérer OPTIONS sans toucher la DB)
// =========================================================================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Content-Type: application/json");
    exit(0);
}

// =========================================================================
// CONNEXION DB + FONCTION nettoyer() VIA config.php
// config.php définit $pdo (PDO) et gère déjà les erreurs de connexion
// =========================================================================
require_once __DIR__ . '/config.php';

$method = $_SERVER['REQUEST_METHOD'];

// =========================================================================
// 1. RÉCUPÉRATION DES COMMENTAIRES (GET)
// =========================================================================
if ($method === 'GET') {
    if (!isset($_GET['video_id'])) {
        echo json_encode(["success" => false, "error" => "Le parametre video_id est manquant."]);
        exit;
    }

    $videoId = nettoyer($_GET['video_id']);

    try {
        $stmt = $pdo->prepare(
            "SELECT * FROM comments WHERE video_id = :video_id ORDER BY date_creation ASC"
        );
        $stmt->execute(['video_id' => $videoId]);
        $allComments = $stmt->fetchAll();

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
    } catch (PDOException $e) {
        error_log("[DEBUG DB] Erreur SELECT : " . $e->getMessage());
        echo json_encode([
            "success" => false,
            "error" => "Erreur lors de la recuperation des commentaires.",
            "debug_pdo_message" => $e->getMessage()
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

    $videoId  = nettoyer($input['video_id']);
    $pseudo   = nettoyer($input['pseudo']);
    $contenu  = nettoyer($input['contenu']);
    $parentId = !empty($input['parent_id']) ? intval($input['parent_id']) : null;

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO comments (video_id, pseudo, contenu, parent_id, date_creation)
             VALUES (:video_id, :pseudo, :contenu, :parent_id, NOW())
             RETURNING *"
        );
        $stmt->execute([
            'video_id'  => $videoId,
            'pseudo'    => $pseudo,
            'contenu'   => $contenu,
            'parent_id' => $parentId,
        ]);
        $inserted = $stmt->fetch();

        echo json_encode([
            "success" => true,
            "message" => "Commentaire ajoute avec succes.",
            "data" => $inserted
        ]);
    } catch (PDOException $e) {
        error_log("[DEBUG DB] Erreur INSERT : " . $e->getMessage());
        echo json_encode([
            "success" => false,
            "error" => "Echec de l'insertion du commentaire.",
            "debug_pdo_message" => $e->getMessage()
        ]);
    }
    exit;
}

echo json_encode(["success" => false, "error" => "Methode non autorisee."]);