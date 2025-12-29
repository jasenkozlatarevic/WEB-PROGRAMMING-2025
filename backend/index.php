<?php
require_once __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/* ================= CORS ================= */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

/* ================= SERVICES ================= */
require_once __DIR__ . '/rest/services/BaseService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/AuthService.php';
require_once __DIR__ . '/rest/services/NoteService.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

Flight::register('users_service', 'UserService');
Flight::register('auth_service', 'AuthService');
Flight::register('note_service', 'NoteService');

Flight::map('auth_middleware', function () {
    return new AuthMiddleware();
});

/* ================= GLOBAL AUTH ================= */
Flight::route('/*', function () {

    $url = Flight::request()->url;

    // JAVNE RUTE (BEZ JWT-a)
    if (
        str_contains($url, '/auth/login') ||
        str_contains($url, '/auth/register') ||
        str_contains($url, '/openapi') ||
        str_contains($url, '/swagger') ||
        str_contains($url, '/public/v1/docs')
    ) {
        return true;
    }

    $auth = Flight::request()->getHeader("Authorization");

    if (!$auth) {
        Flight::halt(401, "Missing Authorization header");
    }

    $token = str_replace("Bearer ", "", $auth);

    try {
        Flight::auth_middleware()->verifyToken($token);
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

/* ================= ROUTES ================= */
require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/NoteRoutes.php';

/* ================= OPENAPI JSON ================= */
Flight::route('GET /openapi', function () {
    header('Content-Type: application/json');
    readfile(__DIR__ . '/openapi.json');
});

/* ================= SWAGGER UI ================= */
Flight::route('GET /swagger', function () {
    require __DIR__ . '/public/v1/docs/index.php';
});


/* ================= START ================= */
Flight::start();
