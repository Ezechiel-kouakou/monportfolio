<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr , http://localhost:5174/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (empty($referer) || strpos($referer, 'ezechielkouakou.fr') === false) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "message" => "Accès direct interdit. Ce flux est réservé au portfolio."
    ]);
    exit;
}

$cache_file = 'data_cache.json';

if (file_exists($cache_file)) {
    $data_raw = file_get_contents($cache_file);

    if (!empty($data_raw)) {
        $payload = json_decode($data_raw, true);

        // --- CORRECTION DYNAMIQUE DU COMPTE A REBOURS ---
        if (isset($payload['videos']) && is_array($payload['videos'])) {
            foreach ($payload['videos'] as &$video) {
                if ($video['mode_suppression'] === '15j' && !empty($video['date_creation'])) {
                    $date_creation = new DateTime($video['date_creation']);
                    $date_suppression = clone $date_creation;
                    $date_suppression->modify('+15 days');
                    
                    // On prend la date actuelle du serveur Azure
                    $aujourd_hui = new DateTime();
                    
                    // Calcul de l'écart réel
                    $diff = $aujourd_hui->diff($date_suppression);
                    
                    // Si la date est dépassée (invert), on met 0, sinon on met le vrai nombre de jours
                    $video['jours_restants'] = $diff->invert ? 0 : $diff->days;
                }
            }
            unset($video); // Libération de la référence
        }

        // Renvoi du JSON mis à jour en temps réel à Vue.js
        echo json_encode($payload);
        // --- FIN DE LA CORRECTION ---

    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Le fichier de cache est vide."
        ]);
    }
} else {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "En attente de synchronisation avec le serveur Penguin."
    ]);
}  
?>