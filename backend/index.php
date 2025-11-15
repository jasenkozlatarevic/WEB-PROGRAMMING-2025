<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

Flight::set('flight.log_errors', true);

/**
 * Helper za čitanje JSON body-a
 */
function get_request_data() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if ($data === null) {
        $data = $_POST;
    }
    return $data;
}

/**
 * ROUTES
 */
require_once __DIR__ . '/routes/userRoutes.php';
require_once __DIR__ . '/routes/categoryRoutes.php';
require_once __DIR__ . '/routes/noteRoutes.php';
require_once __DIR__ . '/routes/tagRoutes.php';
require_once __DIR__ . '/routes/noteTagRoutes.php';

/**
 * OpenAPI JSON
 */
Flight::route('GET /openapi', function () {
    header('Content-Type: application/json');
    readfile(__DIR__ . '/docs/openapi.json');
});

/**
 * Swagger UI dokumentacija
 */
Flight::route('GET /docs', function () {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Notes App API Docs</title>
        <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" />
    </head>
    <body>
    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script>
      window.onload = () => {
        SwaggerUIBundle({
          url: "/openapi",
          dom_id: '#swagger-ui'
        });
      };
    </script>
    </body>
    </html>
    <?php
});

Flight::start();
