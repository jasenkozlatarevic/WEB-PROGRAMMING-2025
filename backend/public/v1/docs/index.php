<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Web Programming API</title>

  <link rel="stylesheet" href="/public/v1/docs/swagger-ui.css">

  <script src="/public/v1/docs/swagger-ui-bundle.js"></script>
  <script src="/public/v1/docs/swagger-ui-standalone-preset.js"></script>

  <style>
    html {
      box-sizing: border-box;
      overflow-y: scroll;
    }
    *, *:before, *:after {
      box-sizing: inherit;
    }
    body {
      margin: 0;
      background: #fafafa;
    }
  </style>
</head>

<body>
  <div id="swagger-ui"></div>

  <script>
    window.onload = function () {
      const ui = SwaggerUIBundle({
        url: "/openapi",
        dom_id: "#swagger-ui",
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout"
      });

      window.ui = ui;
    };
  </script>
</body>
</html>
