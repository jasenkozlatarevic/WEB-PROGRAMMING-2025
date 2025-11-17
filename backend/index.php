<?php
// backend/index.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require __DIR__ . '/vendor/autoload.php'; // assumes Flight via Composer; adjust if needed
require_once __DIR__ . '/config.php';

// Helper to get JSON or form data uniformly
function get_request_data() {
    $raw = file_get_contents('php://input');
    $data = [];
    if (!empty($raw)) {
        $json = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $data = $json;
        }
    }
    if (empty($data) && isset($GLOBALS['__flightRequest'])) {
        // Fallback if Flight::request()->data is configured
        $data = \Flight::request()->data->getData();
    }
    return $data ?: [];
}

// Register a simple DI for PDO
Flight::set('pdo', $conn);

// Include routes
require __DIR__ . '/routes/userRoutes.php';
require __DIR__ . '/routes/categoryRoutes.php';
require __DIR__ . '/routes/noteRoutes.php';
require __DIR__ . '/routes/tagRoutes.php';
require __DIR__ . '/routes/noteTagRoutes.php';

Flight::start();
